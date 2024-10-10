<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// use App\Utils\MenuGenerator;
use App\Http\Controllers\MenuGenerator;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
// use App\Utils\MenuGenerator as UtilsMenuGenerator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /* init::developer date */

    protected $developer = '';
    protected $number = '';
    protected $link = '';
    protected $username = 'azbits';

    /* end::developer date */

    public $data = [];
    public $title = null;
    public $page = null;
    public $pageURL = null;
    public $sistema = 'Sistema Veterinario';
    public function __construct()
    {
        $this->loadMenus();
    }

    protected function loadMenus()
    {
        // Cargar los menús y almacenarlos en la variable de sesión
        // PersonaController
        // session(['menus' => MenuGenerator::generate()]);
    }
    public function render($view)
    {
        // $users = UsuarioModel::where('id_usuario', Auth::id())->first();
        $user = UsuarioModel::getUser(Auth::id());
        $user->image = Helpers::getImage($user->ruta_archivo);
        // dd(UsuarioModel::getUser());
        $this->data['usuario'] = $user;
        // dd($this->data['usuario']);
        // $this->data['notificaciones'] = ContactoModel::whereIn('estado', ['1'])->orderByDesc('fecha_creacion')->get();
        // $this->data['cantidad'] = ContactoModel::whereIn('estado', ['1'])->get()->count();

        // $user =  new UserModel();
        // $user = $user->getUsers(Auth::user()->id);
        // $this->data['rol'] = $user->rol;
        // $this->data['title'] = $this->title;
        // $this->data['page'] = $this->page;
        $menu  = $this->menu();
        $icon  = $this->iconMenu();
        // dd($menu);

        $title = $this->title;
        $data = $this->data;
        $sistema = $this->sistema;
        $page = $this->page;
        $pageURL = $this->pageURL;

        return view('backend.' . $view, compact('data', 'title', 'sistema', 'menu', 'icon', 'page', 'pageURL'));
    }

    protected function menu()
    {
        $data = [];
        /* init::Menu del sistemas */
        // if (Auth::user()->rol == 'ADMIN') {
        $data["administración"] = [
            "usuarios" => "admin-usuario",
        ];
        // }
        $data = array_merge($data, [
            "propietarios" => 'admin-propietario',
            "mascotas" => 'admin-mascota',
        ]);

        return $data;
    }
    protected function iconMenu()
    {
        /* init::Iconos del menu */
        $iconos = [
            // 'titulo vista' =>'icono'
            'panel principal' => 'dashboard',
            'marines' => 'image',
            'estudiantes' => 'group_add',
            'respuestas' => 'fact_check',
            'propietarios' => 'person',
            'mascotas' => 'pets',
            'preguntas' => 'task_alt',
            'administración' => 'manage_accounts',
            'áreas' => 'library_add',
            'entidades' => 'location_city',
            "tests" => 'app_registration',
            "colegios" => 'public',
            "áreas carreras" => 'school',
            "baremo" => 'format_list_numbered',
            "videos" => 'play_circle',
            'resultados' => 'fact_check'
        ];
        return $iconos;
    }
}
