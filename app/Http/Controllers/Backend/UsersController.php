<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class UsersController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UsersController constructor.
     *
     * @param User $user
     */

    private $api_client;
    private $content_client;
    private $access_token;

    public function __construct(User $user)
    {
        $this->user = $user;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->paginate(20);

        return view('dashboard.users.index', compact('users'));
    }

    public function dropboxFileUpload()
    {

        $Client = new Client(env('DROPBOX_TOKEN'));

        $file = fopen(public_path('assets/logo.png'), 'rb');

        $size = filesize(public_path('assets/logo.png'));

        $dropboxFileName = '/myphoto4.png';

        //$adapter = new DropboxAdapter($Client);

        //$filesystem = new Filesystem($adapter);

        //$Client->setConfig('defaults/verify', false);

        //$filesystem->createDir('/newcreatefolder');
        //print_r($filesystem); exit();
        $Client->upload($dropboxFileName,$file);

        // $links['share'] = $Client->createSharedLinkWithSettings($dropboxFileName);

        // $links['view'] = $Client->createFolder($dropboxFileName);

        // print_r($links);

    }
}