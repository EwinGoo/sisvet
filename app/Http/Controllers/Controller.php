<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected const SISTEMA = 'Sistema Veterinario';
    protected const DEVELOPER_INFO = [
        'name' => '',
        'number' => '',
        'link' => '',
        'username' => 'azbits'
    ];

    protected $data = [];
    protected $title;
    protected $page;
    protected $pageURL;

    public function __construct()
    {
        $this->loadMenus();
    }

    protected function loadMenus()
    {
        // Implementar la carga de menús si es necesario
        // session(['menus' => MenuGenerator::generate()]);
    }
    public function render($view)
    {
        $user = $this->getCurrentUser();
        $this->data['usuario'] = $user;
        $viewData = [
            'data' => $this->data,
            'title' => $this->title,
            'sistema' => self::SISTEMA,
            'menu' => $this->getMenu($user),
            'icon' => $this->getIconMenu(),
            'page' => $this->page,
            'pageURL' => $this->pageURL
        ];

        return view('backend.' . $view, $viewData);
    }

    protected function getCurrentUser()
    {
        $user = UsuarioModel::getUser(Auth::id());
        $user->image = Helpers::getImage($user->ruta_archivo);
        return $user;
    }

    protected function getMenu($user): array
    {
         // Menú completo para el grupo administrador
         $grupoAdministrador = ($user->rol == 'administrador') ? [
            "administración" => [
                "usuarios" => "admin-usuario",
            ],
        ]:[];

          // Menús específicos para el grupo médico
          $grupoMedico = ($user->rol == 'medico' || $user->rol == 'administrador') ? [
            '<hr>',
            'CONSULTORIO',
            "propietarios" => 'admin-propietario',
            "mascotas" => 'admin-mascota',
        ]:[];


        // Menús específicos para el grupo vendedor
        $grupoVendedor = ($user->rol == 'vendedor' || $user->rol == 'administrador') ? [
            '<hr>',
            'TIENDA',
            "inventario" => 'admin-inventario',
            "ventas" => 'admin-venta',
            "productos" => 'admin-producto',
            "clientes" => 'admin-cliente',
        ] : [];

      
       

        // Retornar los menús agrupados
        return array_merge($grupoAdministrador,$grupoMedico,$grupoVendedor);
    }

    protected function getIconMenu(): array
    {
        return [
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
            'resultados' => 'fact_check',
            "inventario" => 'inventory',
            "ventas" => 'store',
            "productos" => 'production_quantity_limits',
            "clientes" => 'groups',
        ];
    }
}
