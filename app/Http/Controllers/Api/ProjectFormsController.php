<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectStatement;
use App\Models\StandardStatement;
use App\Models\DefaultStatement;
use App\Models\ProjectForm;
use App\Models\StandardForm;
use App\Models\DefaultFromData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectForm\ProjectFormIndex;
use App\Http\Requests\ProjectForm\ProjectFormUpdate;
use App\Http\Requests\ProjectForm\ProjectFormStore;
use App\Http\Requests\ProjectForm\ProjectFormSignatureUpdate;
use App\Http\Requests\ProjectFooterText\ProjectFooterTextIndex;

//use Elibyy\TCPDF\Facades\TCPDF;
use PDF;
use DB;
use Storage;
use Mail;
use App\Mail\DryFormsPlus;
class ProjectFormsController extends ApiController
{
    /**
     * @var ProjectStatement
     */
    private $projectStatement;
    /**
     * @var StandardStatement
     */
    private $standardStatement;
    /**
     * @var DefaultStatement
     */
    private $defaultStatement;
    /**
     * @var ProjectForm
     */
    private $projectForm;
    /**
     * @var StandardForm
     */
    private $standardForm;
    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * FormsController constructor.
     *
     * @param ProjectForm $projectForm
     */
    public function __construct(ProjectStatement $projectStatement, StandardStatement $standardStatement, StandardForm $standardForm, DefaultFromData $defaultFromData, ProjectForm $projectForm, DefaultStatement $defaultStatement)
    {
        $this->projectStatement = $projectStatement;
        $this->standardStatement = $standardStatement;
        $this->defaultStatement = $defaultStatement;
        $this->projectForm = $projectForm;
        $this->standardForm = $standardForm;
        $this->defaultFormData = $defaultFromData;
    }

    /**
     * @param ProjectFormIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectFormIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();

        $projectForms = $this->projectForm
        	->where('project_id', $queryParams['project_id'])
        	->get();
        return $this->respond($projectForms);
    }

    /**
     * @param ProjectFormStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectFormStore $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
        foreach ($queryParams['project_forms'] as $key => $project_form) {
            $projectForm = $this->projectForm->create($project_form);

            $standardStatement = $this->standardStatement
        		->where('form_id', $project_form['form_id']);        	
        	if ($standardStatement->count() === 0) {
        		$defaultStatements = $this->defaultStatement
	        	->where('form_id', $project_form['form_id'])
	        	->get();
        		foreach ($defaultStatements as $key => $defaultStatement) {
        			$defaultStatement = $defaultStatement->toArray();
        			unset($defaultStatement['id']);
        			unset($defaultStatement['created_at']);
        			unset($defaultStatement['updated_at']);
	        		$defaultStatement['company_id'] = auth()->user()->company_id;
	        		
	        		$this->standardStatement->create($defaultStatement);
	        		$defaultStatement['project_id'] = $project_form['project_id'];
	        		$this->projectStatement->create($defaultStatement);
	        	}
            } else {
        		$standardStatements = $standardStatement->get();
        		foreach ($standardStatements as $key => $standardStatement) {
        			$standardStatement = $standardStatement->toArray();
        			unset($standardStatement['id']);
        			unset($standardStatement['created_at']);
        			unset($standardStatement['updated_at']);
	        		$standardStatement['company_id'] = auth()->user()->company_id;
	        		$standardStatement['project_id'] = $project_form['project_id'];
	        		$this->projectStatement->create($standardStatement);
	        	}
        	}
        }
        return $this->respond(['message' => 'Project Forms successfully created']);
    }

    /**
     * @param ProjectFormUpdate $request
     *
     * @return JsonResponse
     */
    public function update(ProjectFormUpdate $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $projectID = $queryParams['project_id'];
        $oldProjectForms = $this->projectForm
            ->where('project_id', $projectID)
            ->get();
        $newProjectForms = $queryParams['project_forms'];
        foreach ($oldProjectForms as $key => $oldProjectForm) {
            $oldFormID = $oldProjectForm->form_id;
            $found = array_filter($newProjectForms, function($newProjectForm) use ($oldFormID) {
                return $newProjectForm['form_id'] == $oldFormID;
            });
            if (count($found) === 0) {
                $oldProjectForm->delete();
            }
        }
        foreach ($newProjectForms as $key => $newProjectForm) {
            $isExist = $this->projectForm
                ->where('project_id', $projectID)
                ->where('form_id', $newProjectForm['form_id'])
                ->exists();
            if (!$isExist) {
                $this->projectForm->create([
                    'form_id' => $newProjectForm['form_id'],
                    'company_id' => auth()->user()->company_id,
                    'project_id' => $projectID
                ]);
            }
        }
        return $this->respond(['message' => 'Project Forms successfully updated']);
    }

    /**
     * @param ProjectFooterTextIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFooter(ProjectFooterTextIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();

        $standardForm = $this->standardForm
            ->where('form_id', $queryParams['form_id']);
        if ($standardForm->count() > 0) {
            $standardForm = $standardForm->first();
            if ($standardForm->footer_text_show !== 0) {
                return $this->respond([
                    'standardForm' => $standardForm,
                    'message' => 'visible'
                ]);
            } else {
                return $this->respond([
                    'message' => 'invisible'
                ]);
            }
        }

        $defaultFormData = $this->defaultFormData
            ->where('form_id', $queryParams['form_id']);
        if ($defaultFormData->count() > 0) {
            $defaultFormData = $defaultFormData->first();
            if ($defaultFormData->footer_text_show !== 0) {
                return $this->respond([
                    'standardForm' => $defaultFormData,
                    'message' => 'visible'
                ]);
            } else {
                return $this->respond([
                    'message' => 'invisible'
                ]);
            }
        }
    }

    /**
     * @param ProjectFormSignatureUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setSignature(ProjectFormSignatureUpdate $request)
    {
        $project_id = $request->input('project_id');
        $form_id = $request->input('form_id');
        $queryParams = $request->validatedOnly();
        unset($queryParams['id']);

        $projectForm = $this->projectForm
            ->where('project_id', $project_id)
            ->where('form_id', $form_id);
        $projectForm->update($queryParams);

        return $this->respond(['message' => 'Project Signature successfully updated', 'projectForm' => $projectForm->first()]);
    }

    public function print_header($c_imgfile, $c_name, $c_headerdata)
    {
        // add a page
        PDF::AddPage();

        PDF::Image($c_imgfile, 15, 10, 50, 25, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        PDF::SetFont('helvetica', 'B', 15);
        // Title
        PDF::SetY(12);
        PDF::SetX(20);
        PDF::Cell(0, 15, $c_name, 0, false, 'R', 0, '', 0, false, 'M', 'M');

        PDF::SetFont('helvetica', 'B', 10);
        PDF::SetY(16);
        PDF::SetX(-85);
        PDF::MultiCell(70, 150, $c_headerdata, 0, 'R', 0, 1, '', '', true, 0, false, true, 0, 'T', false);

        PDF::SetY(45);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
    }

    public function print_call_report($projectid)
    {
        // ---------------------------------------------------------

        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();

        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Call Report', 0, 1, 'C');
        PDF::Ln(10);

        // set default form properties
        PDF::setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(255, 128, 128)));

        //PDF::MultiCell(55, 5, 'program ', 1, 'L', 1, 0, 35, 100, true);
        PDF::SetFont('helvetica', '', 12);
        
        PDF::SetXY(45,47);
        PDF::Cell(35, 5, 'Job Site');

        PDF::SetFont('helvetica', '', 9);

        PDF::SetXY(15,54);
        PDF::CheckBox('checkbox1', 5, $project_callreport->is_residential, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Residential');

        PDF::SetXY(15,59);
        PDF::CheckBox('checkbox2', 5, $project_callreport->is_insured, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Owner/Insured');

        PDF::SetXY(50,54);
        PDF::CheckBox('checkbox3', 5, $project_callreport->is_commercial, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Commercial');

        PDF::SetXY(50,59);
        PDF::CheckBox('checkbox4', 5, $project_callreport->is_tenant, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Tenant');
        // Contact Name
        PDF::SetXY(15,65);
        PDF::Cell(35, 5, 'Contact Name:');
        PDF::SetXY(15,70);
        PDF::TextField('textfield1', 85, 5, array(), array('v'=>$project_callreport->contact_name));
        PDF::Ln(6);
        // Contact Phone
        PDF::SetXY(15,75);
        PDF::Cell(35, 5, 'Contact Phone:');
        PDF::SetXY(15,80);
        PDF::TextField('textfield2', 85, 5, array(), array('v'=>$project_callreport->contact_phone));
        PDF::Ln(6);
        // Site Phone
        PDF::SetXY(15,85);
        PDF::Cell(35, 5, 'Site Phone:');
        PDF::SetXY(15,90);
        PDF::TextField('textfield3', 85, 5, array(), array('v'=>$project_callreport->site_phone));
        PDF::Ln(6);
        // Date Contacted
        PDF::SetXY(15,95);
        PDF::Cell(35, 5, 'Date Contacted:');
        PDF::SetXY(15,100);
        PDF::TextField('textfield4', 85, 5, array(), array('v'=>$project_callreport->date_contacted));
        PDF::Ln(6);
        // Date of Loss
        PDF::SetXY(15,105);
        PDF::Cell(35, 5, 'Date of Loss:');
        PDF::SetXY(15,110);
        PDF::TextField('textfield5', 85, 5, array(), array('v'=>$project_callreport->date_loss));
        PDF::Ln(6);
        // Point of Loss
        PDF::SetXY(15,115);
        PDF::Cell(35, 5, 'Point of Loss:');
        PDF::SetXY(15,120);
        PDF::TextField('textfield6', 85, 5, array(), array('v'=>$project_callreport->point_loss));
        PDF::Ln(6);
        // Date Completed
        PDF::SetXY(15,125);
        PDF::Cell(35, 5, 'Date Completed:');
        PDF::SetXY(15,130);
        PDF::TextField('textfield7', 85, 5, array(), array('v'=>$project_callreport->date_completed));
        PDF::Ln(6);

        PDF::SetXY(15,137);
        PDF::CheckBox('checkbox5', 5, $project_callreport->is_water, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Water');

        PDF::SetXY(15,142);
        PDF::CheckBox('checkbox6', 5, $project_callreport->is_mold, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Mold');

        PDF::SetXY(50,137);
        PDF::CheckBox('checkbox7', 5, $project_callreport->is_sewage, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Sewage');

        PDF::SetXY(50,142);
        PDF::CheckBox('checkbox8', 5, $project_callreport->is_fire, array(), array(), 'OK');
        PDF::Cell(20, 5, 'Fire');
        
        // Category
        PDF::SetXY(15,150);
        PDF::Cell(35, 5, 'Category:');
        PDF::SetXY(15,155);
        PDF::TextField('textfield8', 85, 5, array(), array('v'=>$project_callreport->category));
        PDF::Ln(6);
        // Class
        PDF::SetXY(15,160);
        PDF::Cell(35, 5, 'Class:');
        PDF::SetXY(15,165);
        PDF::TextField('textfield9', 85, 5, array(), array('v'=>$project_callreport->class));
        PDF::Ln(6);
        // Job Address
        PDF::SetXY(15,170);
        PDF::Cell(35, 5, 'Job Address:');
        PDF::SetXY(15,175);
        PDF::TextField('textfield10', 85, 5, array(), array('v'=>$project_callreport->job_address));
        PDF::Ln(6);
        // City
        PDF::SetXY(15,180);
        PDF::Cell(35, 5, 'City:');
        PDF::SetXY(15,185);
        PDF::TextField('textfield11', 85, 5, array(), array('v'=>$project_callreport->city));
        PDF::Ln(6);
        // State
        PDF::SetXY(15,190);
        PDF::Cell(35, 5, 'State:');
        PDF::SetXY(15,195);
        PDF::TextField('textfield12', 85, 5, array(), array('v'=>$project_callreport->state));
        PDF::Ln(6);
        // Zip Code
        PDF::SetXY(15,200);
        PDF::Cell(35, 5, 'Zip Code:');
        PDF::SetXY(15,205);
        PDF::TextField('textfield13', 85, 5, array(), array('v'=>$project_callreport->zip_code));
        PDF::Ln(6);
        // Cross Streets
        PDF::SetXY(15,210);
        PDF::Cell(35, 5, 'Cross Streets:');
        PDF::SetXY(15,215);
        PDF::TextField('textfield14', 85, 5, array(), array('v'=>$project_callreport->cross_streets));
        PDF::Ln(6);
        // Apartment Name
        PDF::SetXY(15,220);
        PDF::Cell(35, 5, 'Apartment Name:');
        PDF::SetXY(15,225);
        PDF::TextField('textfield15', 85, 5, array(), array('v'=>$project_callreport->apartment_name));
        PDF::Ln(6);
        // Building
        PDF::SetXY(15,230);
        PDF::Cell(35, 5, 'Building #');
        PDF::SetXY(15,235);
        PDF::TextField('textfield16', 85, 5, array(), array('v'=>$project_callreport->building_no));
        PDF::Ln(6);
        // Apartment
        PDF::SetXY(15,240);
        PDF::Cell(35, 5, 'Apartment #');
        PDF::SetXY(15,245);
        PDF::TextField('textfield17', 85, 5, array(), array('v'=>$project_callreport->apartment_no));
        PDF::Ln(6);
        // Gate Code
        PDF::SetXY(15,250);
        PDF::Cell(35, 5, 'Gate Code:');
        PDF::SetXY(15,255);
        PDF::TextField('textfield18', 85, 5, array(), array('v'=>$project_callreport->gate_code));
        PDF::Ln(6);
        // Assigned to
        PDF::SetXY(15,260);
        PDF::Cell(35, 5, 'Assigned to:');
        PDF::SetXY(15,265);
        PDF::TextField('textfield19', 85, 5, array(), array('v'=>$project_callreport->assigned_to));
        PDF::Ln(6);

        //--------------------------------------------------//
        PDF::SetFont('helvetica', '', 12);
        PDF::SetXY(125,47);
        PDF::Cell(35, 5, 'Owner/Insured Information');

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured Name
        PDF::SetXY(110,54);
        PDF::Cell(33, 5, 'Owner/Insured Name:');
        PDF::CheckBox('checkbox9', 5, false, array(), array(), 'OK');
        PDF::Cell(35, 5, 'Same as contact name');
        PDF::SetXY(110,59);
        PDF::TextField('textfield1', 85, 5, array(), array('v'=>$project_callreport->insured_name));
        PDF::Ln(6);
        // Billing Address
        PDF::SetXY(110,64);
        PDF::Cell(33, 5, 'Billing Address:');
        PDF::CheckBox('checkbox10', 5, false, array(), array(), 'OK');
        PDF::Cell(35, 5, 'Same as job address');
        PDF::SetXY(110,69);
        PDF::TextField('textfield10', 85, 5, array(), array('v'=>$project_callreport->billing_address));
        PDF::Ln(6);
        // City
        PDF::SetXY(110,74);
        PDF::Cell(35, 5, 'City:');
        PDF::SetXY(110,79);
        PDF::TextField('textfield20', 85, 5, array(), array('v'=>$project_callreport->insured_city));
        PDF::Ln(6);
        // State
        PDF::SetXY(110,84);
        PDF::Cell(35, 5, 'State:');
        PDF::SetXY(110,89);
        PDF::TextField('textfield21', 85, 5, array(), array('v'=>$project_callreport->insured_state));
        PDF::Ln(6);
        // Zip Code
        PDF::SetXY(110,94);
        PDF::Cell(35, 5, 'Zip Code:');
        PDF::SetXY(110,99);
        PDF::TextField('textfield22', 85, 5, array(), array('v'=>$project_callreport->insured_zip_code));
        PDF::Ln(6);
        // Home Phone
        PDF::SetXY(110,104);
        PDF::Cell(35, 5, 'Home Phone:');
        PDF::SetXY(110,109);
        PDF::TextField('textfield23', 85, 5, array(), array('v'=>$project_callreport->insured_home_phone));
        PDF::Ln(6);
        // Cell Phone
        PDF::SetXY(110,114);
        PDF::Cell(35, 5, 'Cell Phone:');
        PDF::SetXY(110,119);
        PDF::TextField('textfield24', 85, 5, array(), array('v'=>$project_callreport->insured_cell_phone));
        PDF::Ln(6);
        // Work Phone
        PDF::SetXY(110,124);
        PDF::Cell(35, 5, 'Work Phone:');
        PDF::SetXY(110,129);
        PDF::TextField('textfield25', 85, 5, array(), array('v'=>$project_callreport->insured_work_phone));
        PDF::Ln(6);
        // Email
        PDF::SetXY(110,134);
        PDF::Cell(35, 5, 'Email:');
        PDF::SetXY(110,139);
        PDF::TextField('textfield26', 85, 5, array(), array('v'=>$project_callreport->insured_email));
        PDF::Ln(6);
        // Fax
        PDF::SetXY(110,144);
        PDF::Cell(35, 5, 'Fax:');
        PDF::SetXY(110,149);
        PDF::TextField('textfield27', 85, 5, array(), array('v'=>$project_callreport->insured_fax));
        PDF::Ln(6);

        PDF::SetFont('helvetica', '', 12);
        PDF::SetXY(128,155);
        PDF::Cell(35, 5, 'Insurance Information');

        PDF::SetFont('helvetica', '', 9);
        
        // Claim
        PDF::SetXY(110,162);
        PDF::Cell(35, 5, 'Claim #');
        PDF::SetXY(110,167);
        PDF::TextField('textfield28', 85, 5, array(), array('v'=>$project_callreport->insurance_claim_no));
        PDF::Ln(6);
        // Insurance Company
        PDF::SetXY(110,172);
        PDF::Cell(35, 5, 'Insurance Company:');
        PDF::SetXY(110,177);
        PDF::TextField('textfield29', 85, 5, array(), array('v'=>$project_callreport->insurance_company));
        PDF::Ln(6);
        // Policy
        PDF::SetXY(110,182);
        PDF::Cell(35, 5, 'Policy #');
        PDF::SetXY(110,187);
        PDF::TextField('textfield30', 85, 5, array(), array('v'=>$project_callreport->insurance_policy_no));
        PDF::Ln(6);
        // Deductible
        PDF::SetXY(110,192);
        PDF::Cell(35, 5, 'Deductible:');
        PDF::SetXY(110,197);
        PDF::TextField('textfield31', 85, 5, array(), array('v'=>$project_callreport->insurance_deductible));
        PDF::Ln(6);
        // Insurance Adjuster
        PDF::SetXY(110,202);
        PDF::Cell(35, 5, 'Insurance Adjuster:');
        PDF::SetXY(110,207);
        PDF::TextField('textfield32', 85, 5, array(), array('v'=>$project_callreport->insurance_adjuster));
        PDF::Ln(6);
        // Address
        PDF::SetXY(110,212);
        PDF::Cell(35, 5, 'Address:');
        PDF::SetXY(110,217);
        PDF::TextField('textfield33', 85, 5, array(), array('v'=>$project_callreport->insurance_address));
        PDF::Ln(6);
        // City
        PDF::SetXY(110,222);
        PDF::Cell(35, 5, 'City:');
        PDF::SetXY(110,227);
        PDF::TextField('textfield34', 85, 5, array(), array('v'=>$project_callreport->insurance_city));
        PDF::Ln(6);
        // State
        PDF::SetXY(110,232);
        PDF::Cell(35, 5, 'State:');
        PDF::SetXY(110,237);
        PDF::TextField('textfield35', 85, 5, array(), array('v'=>$project_callreport->insurance_state));
        PDF::Ln(6);
        // Zip Code
        PDF::SetXY(110,242);
        PDF::Cell(35, 5, 'Zip Code:');
        PDF::SetXY(110,247);
        PDF::TextField('textfield36', 85, 5, array(), array('v'=>$project_callreport->insurance_zip_code));
        PDF::Ln(6);
        // Work Phone
        PDF::SetXY(110,252);
        PDF::Cell(35, 5, 'Work Phone:');
        PDF::SetXY(110,257);
        PDF::TextField('textfield37', 40, 5, array(), array('v'=>$project_callreport->insurance_work_phone));
        PDF::Ln(6);
        // Cell Phone
        PDF::SetXY(155,252);
        PDF::Cell(35, 5, 'Cell Phone:');
        PDF::SetXY(155,257);
        PDF::TextField('textfield38', 40, 5, array(), array('v'=>$project_callreport->insurance_cell_phone));
        PDF::Ln(6);
        // Email
        PDF::SetXY(110,262);
        PDF::Cell(35, 5, 'Email:');
        PDF::SetXY(110,267);
        PDF::TextField('textfield39', 40, 5, array(), array('v'=>$project_callreport->insurance_email));
        PDF::Ln(6);
        // Fax
        PDF::SetXY(155,262);
        PDF::Cell(35, 5, 'Fax:');
        PDF::SetXY(155,267);
        PDF::TextField('textfield40', 40, 5, array(), array('v'=>$project_callreport->insurance_fax));
        PDF::Ln(6);
    }

    public function print_daily_log($projectid)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        $project_dailylogs = DB::table('project_dailylogs')->where('project_id', $projectid)->get();

        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Daily Log', 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured3", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job3", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim3", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));

        PDF::SetY(70);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
        
        for($i = 0; $i < count($project_dailylogs); $i ++){  
            // Log
            PDF::SetFont('helvetica', '', 10, '', false);
            PDF::SetXY(15,80 + $i * 25);
            PDF::Cell(35, 5, $project_dailylogs[$i]->updated_at . ' admin admin');

            PDF::SetFont('helvetica', '', 9);
            PDF::SetXY(15,80 + $i * 25 + 5);
            PDF::TextField("log$i", 180, 18, array('multiline'=>true), array('v'=>$project_dailylogs[$i]->notes));
            PDF::Ln(19);
        }
    }
    public function print_work_authorization($projectid, $formid, $title)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        $project_forms = DB::table('project_forms')->where('project_id', $projectid)->where('form_id', $formid)->first();
        $project_statements = DB::table('project_statements')->where('project_id', $projectid)->where('form_id', $formid)->first();
        //get company id
        $company = DB::table('companies')->where('id', $project_forms->company_id)->first();

        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, $title, 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured$formid", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job$formid", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim$formid", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));


        PDF::SetY(70);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
        
        //statement
        PDF::SetFont('helvetica', '', 10, '', false);
        PDF::SetXY(15,75);
        PDF::Cell(35, 6, $project_statements->title);
        PDF::SetFont('helvetica', '', 15, '', false);
        PDF::SetXY(15,82);
        PDF::Cell(35, 6, $project_statements->statement);

        PDF::SetY(95);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
        //signature
        PDF::SetFont('helvetica', '', 10, '', false);
        PDF::SetXY(15,105);
        PDF::Cell(35, 6, 'Owner/Insured:');

        PDF::Image($project_forms->insured_signature, 80, 100, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,120);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,108);
        PDF::TextField("insureddate$formid", 35, 6, array(), array('v'=>$project_forms->insured_signature_upated_at));
        PDF::SetXY(15,112);
        PDF::TextField("insured$formid", 25, 5, array(), array('v'=>$project_callreport->insured_name));
        //PDF::Ln(6);

        PDF::SetXY(15,130);
        PDF::Cell(35, 6, 'Company:');
        
        PDF::Image($project_forms->company_signature, 80, 125, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,145);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,133);
        PDF::TextField("companydate$formid", 35, 6, array(), array('v'=>$project_forms->company_signature_upated_at));
        PDF::SetXY(15,137);
        PDF::TextField("company$formid", 25, 5, array(), array('v'=>$company->name));
        //PDF::Ln(6);
    }
    public function print_anti_microbial($projectid)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        $project_forms = DB::table('project_forms')->where('project_id', $projectid)->where('form_id', 5)->first();
        $project_statements = DB::table('project_statements')->where('project_id', $projectid)->where('form_id', 5)->get();
        //get company id
        $company = DB::table('companies')->where('id', $project_forms->company_id)->first();
        
        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Anti-microbial Authorization', 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured5", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job5", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim5", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));

        PDF::SetY(70);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
        
        //statement
        for($i = 0; $i < count($project_statements); $i ++){
            PDF::SetFont('helvetica', '', 10, '', false);
            PDF::SetXY(15,75 + $i * 25);
            PDF::Cell(35, 6, $project_statements[$i]->title);
            PDF::SetFont('helvetica', '', 15, '', false);
            PDF::SetXY(15,82 + $i * 25);
            PDF::Cell(35, 6, $project_statements[$i]->statement);
            PDF::SetY(95 + $i * 25);
            PDF::Cell(180, 0, '', 'T', 0, 'C');
        }

        //signature
        PDF::SetFont('helvetica', '', 10, '', false);
        PDF::SetXY(15,130);
        PDF::Cell(35, 6, 'Owner/Insured:');
        PDF::Image($project_forms->insured_signature, 80, 125, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,145);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,133);
        PDF::TextField("insureddate5", 35, 6, array(), array('v'=>$project_forms->insured_signature_upated_at));
        PDF::SetXY(15,137);
        PDF::TextField("insured5", 25, 5, array(), array('v'=>$project_callreport->insured_name));
        //PDF::Ln(6);

        PDF::SetXY(15,155);
        PDF::Cell(35, 6, 'Company:');
        
        PDF::Image($project_forms->company_signature, 80, 150, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,170);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,158);
        PDF::TextField("companydate5", 35, 6, array(), array('v'=>$project_forms->company_signature_upated_at));
        PDF::SetXY(15,162);
        PDF::TextField("company5", 25, 5, array(), array('v'=>$company->name));
        //PDF::Ln(6);
    }
    public function print_customer_responsibility($projectid)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        $project_forms = DB::table('project_forms')->where('project_id', $projectid)->where('form_id', 6)->first();
        $project_statements = DB::table('project_statements')->where('project_id', $projectid)->where('form_id', 6)->first();
        $equipments = DB::table('equipments')->where('status_id', 3)->where('company_id', $project_forms->company_id)->get();
        //get company id
        $company = DB::table('companies')->where('id', $project_forms->company_id)->first();

        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Customer Responsibility', 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured6", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job6", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim6", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));


        PDF::SetY(70);
        PDF::Cell(180, 0, '', 'T', 0, 'C');
        
        //statement
        PDF::SetFont('helvetica', '', 10, '', false);
        PDF::SetXY(15,75);
        PDF::Cell(35, 6, $project_statements->title);
        PDF::SetFont('helvetica', '', 15, '', false);
        PDF::SetXY(15,82);
        PDF::Cell(35, 6, $project_statements->statement);

        PDF::SetY(95);
        PDF::Cell(180, 0, '', 'T', 0, 'C');

        PDF::SetFont('helvetica', '', 10);
        $tbl = "<table cellspacing=\"0\" cellpadding=\"1\" border=\"1\" align=\"center\">
            <tr>
                <td width=\"90\" height=\"5\">Category</td>
                <td width=\"90\" height=\"5\">Make/Model</td>
                <td width=\"90\" height=\"5\">Equipment</td>
                <td width=\"90\" height=\"5\">Crew/Team</td>
                <td width=\"90\" height=\"5\">Location</td>
                <td width=\"90\" height=\"5\">Status</td>
                <td width=\"90\" height=\"5\">Action</td>
            </tr>";
        for($i = 0; $i < count($equipments); $i ++){
            $model = DB::table('equipment_models')->where('id', $equipments[$i]->model_id)->first();
            $category = DB::table('equipment_categories')->where('id', $model->category_id)->first();
            $team = DB::table('teams')->where('id', $equipments[$i]->team_id)->first();
            $status = DB::table('equipment_statuses')->where('id', $equipments[$i]->status_id)->first();
            $tbl1 = "<tr>
                <td width=\"90\">" . $category->name . "</td>
                <td width=\"90\">" . $model->name . "</td>
                <td width=\"90\">" . $equipments[$i]->serial . "</td>
                <td width=\"90\">" . $team->name . "</td>
                <td width=\"90\">" . $equipments[$i]->location . "</td>
                <td width=\"90\">" . $status->name . "</td>
                <td width=\"90\"></td>
            </tr>";
            $tbl .= $tbl1;
        }
        $tbl .= "</table>";
        PDF::SetXY(15,100);
        PDF::writeHTML($tbl, true, false, false, false, '');
        
        //signature
        PDF::SetFont('helvetica', '', 10, '', false);
        PDF::SetXY(15,130);
        PDF::Cell(35, 6, 'Owner/Insured:');
        PDF::Image($project_forms->insured_signature, 80, 125, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,145);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,133);
        PDF::TextField("insureddate6", 35, 6, array(), array('v'=>$project_forms->insured_signature_upated_at));
        PDF::SetXY(15,136);
        PDF::TextField("company6", 25, 5, array(), array('v'=>$project_callreport->insured_name));
        //PDF::Ln(6);

        PDF::SetXY(15,155);
        PDF::Cell(35, 6, 'Company:');
        
        PDF::Image($project_forms->company_signature, 80, 150, 60, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        PDF::SetXY(80,170);
        PDF::Cell(60, 0, '', 'T', 0, 'C');
        PDF::SetXY(160,158);
        PDF::TextField("companydate6", 35, 6, array(), array('v'=>$project_forms->company_signature_upated_at));
        PDF::SetXY(15,160);
        PDF::TextField("company6", 25, 5, array(), array('v'=>$company->name));
        //PDF::Ln(6);
        
    }

    public function print_moisture_map($projectid)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        
        $structures = DB::table('standard_structures')->get();
        $materials = DB::table('standard_materials')->get();

        $project_area_ids = DB::table('project_areas')->where('project_id', $projectid)->get();

        $result_areas = array();
        $result_settings = array();
        $result_days = array();
        for($i = 0; $i < count($project_area_ids); $i ++){
            $area = DB::table('areas')->where('id', $project_area_ids[$i]->area_id)->first();
            $result_areas[] = $area->title;
            $area_settings = DB::table('project_moisture_settings')->where('project_area_id', $project_area_ids[$i]->id)->get();
            $result_settings[] = $area_settings;
            $result = array();
            for($j = 0; $j < count($area_settings); $j ++){
                $current = DB::table('project_moisture_days')->where('area_setting_id', $area_settings[$j]->id)->get();
                for($l = 0; $l < count($current); $l ++){
                    $result[$l][] = $current[$l];
                }
            }
            $result_days[] = $result;
        }
        for($i = 0; $i < count($result_areas); $i ++){
            for($j = 0; $j <= 7; $j ++){
                $standard_structure = DB::table('standard_structures')->where('id', $result_settings[$i][$j]->structure_id)->first();
                $standard_matarial = DB::table('standard_materials')->where('id', $result_settings[$i][$j]->matarial_id)->first();
                if(!isset($standard_structure->title)){
                    $result_settings[$i][$j]->structure_title = "n/a";
                }
                else{
                    $result_settings[$i][$j]->structure_title = $standard_structure->title;
                }
                if(!isset($standard_matarial->title)){
                    $result_settings[$i][$j]->matarial_title = "n/a";
                }
                else{
                    $result_settings[$i][$j]->matarial_title = $standard_matarial->title;
                }
            }
        }
        
        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Moisture Map', 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured6", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job6", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim6", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));

        if (empty($result_settings)) {
            return;
        }
        $posX = 15; $posY = 70;
        for($i = 0; $i < count($result_areas); $i ++){
            if($posY+22+15*count($result_days[$i]) > 270){
                PDF::AddPage();
                $posX = 15; $posY = 10;
            }
            $menu_title = $result_areas[$i];
            PDF::SetFont('helvetica', '', 10);
            $tbl = "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0.5\" nobr=\"true\" align=\"center\">
                     <tr style=\"background-color:#c3c3c3; font-weight:bold;\">
                      <th colspan=\"8\">$menu_title</th>
                     </tr>
                     <tr>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][0]->structure_title."</td>
                      <td>".$result_settings[$i][1]->structure_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][2]->structure_title."</td>
                      <td>".$result_settings[$i][3]->structure_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][4]->structure_title."</td>
                      <td>".$result_settings[$i][5]->structure_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][6]->structure_title."</td>
                      <td>".$result_settings[$i][7]->structure_title."</td>
                     </tr>
                     <tr>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][0]->matarial_title."</td>
                      <td>".$result_settings[$i][1]->matarial_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][2]->matarial_title."</td>
                      <td>".$result_settings[$i][3]->matarial_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][4]->matarial_title."</td>
                      <td>".$result_settings[$i][5]->matarial_title."</td>
                      <td style=\"background-color:#c3c3c3;\">".$result_settings[$i][6]->matarial_title."</td>
                      <td>".$result_settings[$i][7]->matarial_title."</td>
                     </tr>
                    </table>";
            PDF::SetXY($posX,$posY);
            $posY += 22;
            PDF::writeHTML($tbl, true, false, false, false, '');
            for($j = 0; $j < count($result_days[$i]); $j ++){
                $tbl = "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0.5\" nobr=\"true\" align=\"center\">
                 <tr>
                  <th colspan=\"8\">".$result_days[$i][$j][0]->current_time."</th>
                 </tr>
                 <tr>
                  <td>".$result_days[$i][$j][0]->amount."</td>
                  <td>".$result_days[$i][$j][1]->amount."</td>
                  <td>".$result_days[$i][$j][2]->amount."</td>
                  <td>".$result_days[$i][$j][3]->amount."</td>
                  <td>".$result_days[$i][$j][4]->amount."</td>
                  <td>".$result_days[$i][$j][5]->amount."</td>
                  <td>".$result_days[$i][$j][6]->amount."</td>
                  <td>".$result_days[$i][$j][7]->amount."</td>
                 </tr>
                </table>";
                PDF::SetXY($posX,$posY);
                PDF::writeHTML($tbl, true, false, false, false, '');
                $posY += 15;
            }
            $posY += 5;
        }
        
    }
    public function print_psychometric_report($projectid)
    {
        // ---------------------------------------------------------
        $project_callreport = DB::table('project_call_reports')->where('project_id', $projectid)->first();
        $project_forms = DB::table('project_forms')->where('project_id', $projectid)->where('form_id', 8)->first();
        
        $projectAreas = DB::table('project_areas')->where('project_id', $projectid)->get();
        $timedatas = array();
        $areadatas = array();
        foreach($projectAreas as $key => $area){
            $areainfo = DB::table('areas')->where('id', $area->area_id)->first();
            $areadatas[$area->id] = $areainfo->title;
            $data = DB::table('project_psychometric_days')->where('area_id', $area->id)->get();
            foreach($data as $i => $row){
                $timedatas[$row->current_time][] = $row;
            }
        }

        $company = DB::table('companies')->where('id', $project_forms->company_id)->first();

        PDF::SetY(37);
        PDF::SetFont('helvetica', 'BI', 15);
        PDF::Cell(0, 5, 'Psychometric Report', 0, 1, 'C');
        PDF::Ln(10);

        PDF::SetFont('helvetica', '', 9);

        // Owner/Insured
        PDF::SetXY(15,50);
        PDF::Cell(25, 5, 'Owner/Insured:');
        PDF::TextField("insured8", 30, 5, array(), array('v'=>$project_callreport->insured_name));

        // Job Address
        PDF::SetXY(15,60);
        PDF::Cell(23, 5, 'Job Address:');
        PDF::TextField("job8", 30, 5, array(), array('v'=>$project_callreport->job_address));
        // Claim
        PDF::SetXY(150,50);
        PDF::Cell(20, 5, 'Claim#', 0, false, 'R');
        PDF::TextField("claim8", 25, 5, array(), array('v'=>$project_callreport->insurance_claim_no));

        $posX = 15; $posY = 70;
        foreach($timedatas as $key => $data){
            if($posY+25+20*count($data) > 270){
                PDF::AddPage();
                $posX = 15; $posY = 10;
            }
            PDF::SetFont('helvetica', '', 10);
            $tbl = "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0.5\" nobr=\"true\" align=\"center\">
                     <tr style=\"background-color:#c3c3c3; font-weight:bold;\">
                      <th colspan=\"20\">$key</th>
                     </tr>
                     <tr>
                      <td colspan=\"4\" style=\"background-color:#c3c3c3;\">Outside</td>
                      <td colspan=\"4\">Unaffected</td>
                      <td colspan=\"4\" style=\"background-color:#c3c3c3;\">Affected</td>
                      <td colspan=\"4\">Dehumidifier</td>
                      <td colspan=\"4\" style=\"background-color:#c3c3c3;\">Hvac</td>
                     </tr>
                     <tr>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">TEMP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">RH%</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">GPP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">DEW</td>
                      <td style=\"font-size:8px;\">TEMP</td>
                      <td style=\"font-size:8px;\">RH%</td>
                      <td style=\"font-size:8px;\">GPP</td>
                      <td style=\"font-size:8px;\">DEW</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">TEMP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">RH%</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">GPP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">DEW</td>
                      <td style=\"font-size:8px;\">TEMP</td>
                      <td style=\"font-size:8px;\">RH%</td>
                      <td style=\"font-size:8px;\">GPP</td>
                      <td style=\"font-size:8px;\">DEW</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">TEMP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">RH%</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">GPP</td>
                      <td style=\"font-size:8px; background-color:#c3c3c3;\">DEW</td>
                     </tr>
                    </table>";
            PDF::SetXY($posX,$posY);
            $posY += 25;
            PDF::writeHTML($tbl, true, false, false, false, '');
            for($j = 0; $j < count($data); $j ++){
                $outside = json_decode($data[$j]->outside);
                $unaffected = json_decode($data[$j]->unaffected);
                $affected = json_decode($data[$j]->affected);
                $dehumidifier = json_decode($data[$j]->dehumidifier);
                $hvac = json_decode($data[$j]->hvac);
                $outside->dew = round($outside->dew, 2);
                $unaffected->dew = round($unaffected->dew, 2);
                $affected->dew = round($affected->dew, 2);
                $dehumidifier->dew = round($dehumidifier->dew, 2);
                $hvac->dew = round($hvac->dew, 2);
                $tbl = "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0.5\" nobr=\"true\" align=\"center\">
                 <tr>
                  <th colspan=\"20\">".$areadatas[$data[$j]->area_id]."</th>
                 </tr>
                 <tr>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$outside->temp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$outside->rh."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$outside->gpp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$outside->dew."</td>
                  <td style=\"font-size:8px;\">".$unaffected->temp."</td>
                  <td style=\"font-size:8px;\">".$unaffected->rh."</td>
                  <td style=\"font-size:8px;\">".$unaffected->gpp."</td>
                  <td style=\"font-size:8px;\">".$unaffected->dew."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$affected->temp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$affected->rh."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$affected->gpp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$affected->dew."</td>
                  <td style=\"font-size:8px;\">".$dehumidifier->temp."</td>
                  <td style=\"font-size:8px;\">".$dehumidifier->rh."</td>
                  <td style=\"font-size:8px;\">".$dehumidifier->gpp."</td>
                  <td style=\"font-size:8px;\">".$dehumidifier->dew."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$hvac->temp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$hvac->rh."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$hvac->gpp."</td>
                  <td style=\"font-size:8px; background-color:#c3c3c3;\">".$hvac->dew."</td>
                 </tr>
                </table>";
                PDF::SetXY($posX,$posY);
                PDF::writeHTML($tbl, true, false, false, false, '');
                $posY += 20;
            }
            $posY += 5;
        }
    }
    public function print(Request $request, int $id)
    {
        $formids = $request->all();
        $flag = 0;
        if(isset($formids['form0'])){
            $flag = 1;
        }
        
        $companyid = DB::table('project_forms')->where('project_id', $id)->first();
        $companyid = $companyid->company_id;
        $company = DB::table('companies')->where('id', $companyid)->first();

        $c_name = $company->name;
        $c_street = $company->street;
        $c_address = $company->city . ' ' . $company->state . ' ' . $company->zip;
        $c_phone = $company->phone;
        $c_email = $company->email;

        $c_imgfile = "../resources/frontend/src/assets/fallback-logo.jpg";
        $c_headerdata = "$c_street\n$c_address\n$c_phone\n$c_email";

        //--------------------create PDF document----------------------//
        //$pdf = new PDF();

        // set document information
        PDF::SetTitle('dryforms-print');

        PDF::setPrintHeader(false);
        
        // Page footer
        PDF::setFooterCallback(function($cpdf) {
            // Position at 15 mm from bottom
            $cpdf->SetY(-15);
            // Set font
            $cpdf->SetFont('helvetica', 'I', 8);
            // Page number
            $cpdf->Cell(0, 10, 'Page '.$cpdf->getAliasNumPage().'/'.$cpdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        
        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            PDF::setLanguageArray($l);
        }
        // IMPORTANT: disable font subsetting to allow users editing the document
        PDF::setFontSubsetting(false);

        $projectid = $id;
        if($flag == 0){
            for($i = 1; $i <= 12; $i ++){
                $formids[] = $i;    
            }
        }
        
        foreach($formids as $key => $value){
            $project_statement = DB::table('project_statements')->where('project_id', $projectid)->where('form_id', $value)->first();
            $stateflag = false;
            if(isset($project_statement)){
                $stateflag = true;
            }
            if($value == 1){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_call_report($projectid);
            }
            else if($value == 2){
                
            }
            else if($value == 3){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_daily_log($projectid);
            }
            else if($value == 4 && $stateflag == true){

                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 4, "Work Authorization");
            }
            else if($value == 5 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_anti_microbial($projectid);
            }
            else if($value == 6 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata); 
                $this->print_customer_responsibility($projectid);
            }
            else if($value == 7){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_moisture_map($projectid);
            }
            else if($value == 8){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_psychometric_report($projectid);
            }
            else if($value == 9 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 9, "Release from Liability");
            }
            else if($value == 10 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 10, "Work Stoppage");
            }
            else if($value == 11 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 11, "Certificate of Completion");
            }
        }
        //PDF::Output(__DIR__ . "/temp/dryforms_project.pdf",'F');
        if($flag == 0){
            PDF::Output("dryforms_project.pdf",'I');
        }
        else if($flag == 1){
            PDF::Output("dryforms_project.pdf",'D');   
        }
    }

    public function primaryPrint()
    {
        //--------------------create PDF document----------------------//
        //$pdf = new PDF();

        // set document information
        PDF::SetTitle('dryforms-print');

        PDF::setPrintHeader(false);
        
        // Page footer
        PDF::setFooterCallback(function($cpdf) {
            // Position at 15 mm from bottom
            $cpdf->SetY(-15);
            // Set font
            $cpdf->SetFont('helvetica', 'I', 8);
            // Page number
            $cpdf->Cell(0, 10, 'Page '.$cpdf->getAliasNumPage().'/'.$cpdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        
        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            PDF::setLanguageArray($l);
        }
        // IMPORTANT: disable font subsetting to allow users editing the document
        PDF::setFontSubsetting(false);
    }

    public function prepareEmail(Request $request)
    {
        $selectedPDFType = $request->selectedPDFType;
        $selectedForms = array();
        $formid = -1;
        if($selectedPDFType == 1){
            $selectedForms[] = $request->selectedForm;
            $formid = $request->selectedForm;
        }
        else{
            $selectedForms = $request->selectedForm;
        }
        $selectedRecipients = $request->selectedRecipients;
        $projectid = $request->project_id;

        $companyid = DB::table('project_forms')->where('project_id', $projectid)->first();
        $companyid = $companyid->company_id;
        $company = DB::table('companies')->where('id', $companyid)->first();

        
        $this->primaryPrint();

        $c_name = $company->name;
        $c_street = $company->street;
        $c_address = $company->city . ' ' . $company->state . ' ' . $company->zip;
        $c_phone = $company->phone;
        $c_email = $company->email;

        $c_imgfile = "../resources/frontend/src/assets/fallback-logo.jpg";
        $c_headerdata = "$c_street\n$c_address\n$c_phone\n$c_email";

        foreach($selectedForms as $key => $value){
            $project_statement = DB::table('project_statements')->where('project_id', $projectid)->where('form_id', $value)->first();
            $stateflag = false;
            if(isset($project_statement)){
                $stateflag = true;
            }
            if($value == 1){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_call_report($projectid);
            }
            else if($value == 2){
                
            }
            else if($value == 3){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_daily_log($projectid);
            }
            else if($value == 4 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 4, "Work Authorization");
            }
            else if($value == 5 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_anti_microbial($projectid);
            }
            else if($value == 6 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata); 
                $this->print_customer_responsibility($projectid);
            }
            else if($value == 7){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_moisture_map($projectid);
            }
            else if($value == 8){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);
                $this->print_psychometric_report($projectid);
            }
            else if($value == 9 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 9, "Release from Liability");
            }
            else if($value == 10 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 10, "Work Stoppage");
            }
            else if($value == 11 && $stateflag == true){
                $this->print_header($c_imgfile, $c_name, $c_headerdata);        
                $this->print_work_authorization($projectid, 11, "Certificate of Completion");
            }
        }
        if($selectedPDFType == 1){
            PDF::Output(__DIR__ . "/temp/dryforms_project$projectid-$formid.pdf",'F');
            if($request->lastForm == $formid){
                return redirect()->route('send-email', ['projectId'=>$projectid, 'pdfFlag'=>1, 'allForms' => $request->allFroms, 'address'=>$request->address]);
            }
        }
        else{
            PDF::Output(__DIR__ . "/temp/dryforms_project$projectid.pdf",'F');
            return redirect()->route('send-email',['projectId'=>$projectid, 'pdfFlag'=>2, 'address'=>$request->address]);
        }
    }
    public function sendEmail(Request $request)
    {
        Mail::to($request->address)->send(new DryFormsPlus($request->projectId, $request->pdfFlag, $request->allForms));
    }
}
