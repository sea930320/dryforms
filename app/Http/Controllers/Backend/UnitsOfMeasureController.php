<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Uoms\UomStore;
use App\Http\Requests\Uoms\UomUpdate;
use App\Models\UnitOfMeasure;
use Prologue\Alerts\Facades\Alert;

class UnitsOfMeasureController extends Controller
{
    /**
     * @var UnitOfMeasure
     */
    private $uom;

    /**
     * UnitsOfMeasureController constructor.
     *
     * @param UnitOfMeasure $uom
     */
    public function __construct(UnitOfMeasure $uom)
    {
        $this->uom = $uom;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $uoms = $this->uom->paginate(20);

        return view('dashboard.items.uom.index', compact('uoms'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.items.uom.form');
    }

    /**
     * @param UomStore $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UomStore $request)
    {
        $this->uom->create([
            'title' => $request->get('title')
        ]);

        Alert::success('Unit Of Measure successfully created')->flash();

        return redirect()->route('units-of-measure.index')->with('alerts', Alert::all());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $uom = $this->uom->findOrFail($id);

        return view('dashboard.items.uom.form', compact('uom'));
    }

    /**
     * @param UomUpdate $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UomUpdate $request)
    {
        $uom = $this->uom->find($request->get('uom_id'));
        $uom->title = $request->get('title');
        $uom->save();

        Alert::success('Unit Of Measure successfully updated')->flash();

        return redirect()->back()->with('alerts', Alert::all());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $uom = $this->uom->findOrFail($id);
        $uom->delete();

        Alert::success('Unit Of Measure successfully deleted')->flash();

        return redirect()->route('units-of-measure.index')->with('alerts', Alert::all());
    }
}