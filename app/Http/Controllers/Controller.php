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
    protected $area;

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
            'usuario'=> $user,
            'icon' => $this->getIconMenu(),
            'page' => $this->page,
            'area' => $this->area,
            'pageURL' => $this->pageURL
        ];

        return view('backend.' . $view, $viewData);
    }

    protected function getCurrentUser()
    {
        $user = UsuarioModel::getUser(Auth::id());
        // dd(Auth::user());
        $user->image = Helpers::getImage($user->ruta_archivo);
        return $user;
    }

    protected function getMenu($user): array
    {
         // Menú completo para el grupo administrador
         $grupoAdministrador = ($user->rol == 'administrador') ? [
            "administración" => [
                "usuarios" => "admin-usuario",
                "Backup DB" => "admin-db",
            ],
            "Panel Principal" => 'dashboard',
        ]:[];

          // Menús específicos para el grupo médico
          $grupoMedico = ($user->rol == 'médico' || $user->rol == 'administrador') ? [
            "Panel Principal" => 'dashboard',
            '<hr>',
            'CONSULTORIO',
            "calendario" => 'admin-calendario',
            "propietarios" => 'admin-propietario',
            "citas" => 'admin-cita',
            "mascotas" => 'admin-mascota',
            "razas" => 'admin-raza',
        ]:[];


        // Menús específicos para el grupo vendedor
        $grupoVendedor = ($user->rol == 'vendedor' || $user->rol == 'administrador') ? [
            "Panel Principal" => 'dashboard',
            '<hr>',
            'TIENDA',
            "inventario" => 'admin-inventario',
            "ventas" => 'admin-venta',
            "productos" => 'admin-producto',
            "compras" => 'admin-compra',
            "proveedores" => 'admin-proveedor',
            "clientes" => 'admin-cliente',
        ] : [];




        // Retornar los menús agrupados
        return array_merge($grupoAdministrador,$grupoMedico,$grupoVendedor);
    }

    protected function getIconMenu(): array
    {
        return [
            'Panel Principal' => 'dashboard',
            'marines' => 'image',
            'estudiantes' => 'group_add',
            'respuestas' => 'fact_check',
            'calendario' => 'event_available',
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
            "razas" => 'format_list_bulleted',
            "proveedores" => 'group',
            "citas" => 'calendar_month',
            "compras" => 'add_shopping_cart',
        ];
    }
}
