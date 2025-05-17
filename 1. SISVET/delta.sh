#!/bin/bash

# Nombre del módulo (az crud)
MODULE_NAME=$1

# Directorios base
CONTROLLER_DIR="app/Controllers"
MODEL_DIR="app/Models"
VIEW_DIR="app/Views/$MODULE_NAME"
JS_DIR="public/js/$MODULE_NAME"
import os

def create_directory(path):
    if not os.path.exists(path):
        os.makedirs(path)

def create_file(path, content):
    with open(path, 'w') as file:
        file.write(content)

def generate_crud(module_name):
    # Directorios base
    base_dir = os.getcwd()
    controller_dir = os.path.join(base_dir, 'controllers')
    model_dir = os.path.join(base_dir, 'models')
    view_dir = os.path.join(base_dir, f'views/{module_name}')
    js_dir = os.path.join(base_dir, f'static/js/{module_name}')

    # Crear directorios
    create_directory(controller_dir)
    create_directory(model_dir)
    create_directory(view_dir)
    create_directory(js_dir)

    # Contenido de los archivos
    controller_content = f"""class {module_name.capitalize()}Controller:
    def __init__(self):
        pass

    def index(self):
        return "This is the {module_name} controller index."
"""
    model_content = f"""class {module_name.capitalize()}Model:
    def __init__(self):
        self.table = '{module_name}'
        self.primary_key = 'id'

    def find_all(self):
        return "Query all records from the {module_name} table."
"""
    view_content = f"""<h1>{module_name.capitalize()} View</h1>
<p>This is the view for {module_name}.</p>
"""
    js_content = f"""console.log('JavaScript for {module_name}.');
"""

    # Rutas de los archivos
    controller_file = os.path.join(controller_dir, f'{module_name}_controller.py')
    model_file = os.path.join(model_dir, f'{module_name}_model.py')
    view_file = os.path.join(view_dir, 'index.html')
    js_file = os.path.join(js_dir, f'{module_name}.js')

    # Crear archivos
    create_file(controller_file, controller_content)
    create_file(model_file, model_content)
    create_file(view_file, view_content)
    create_file(js_file, js_content)

    print(f"Módulo '{module_name}' creado con éxito.")

if __name__ == "__main__":
    module_name = input("Introduce el nombre del módulo: ")
    generate_crud(module_name)

# Crear directorios si no existen
mkdir -p $CONTROLLER_DIR
mkdir -p $MODEL_DIR
mkdir -p $VIEW_DIR
mkdir -p $JS_DIR

# Generar archivo de controlador
CONTROLLER_FILE="$CONTROLLER_DIR/${MODULE_NAME^}Controller.php"
echo "<?php

namespace App\Controllers;

class ${MODULE_NAME^}Controller extends BaseController
{
    public function index()
    {
        // Código para la acción 'index'
    }
}" > $CONTROLLER_FILE

# Generar archivo de modelo
MODEL_FILE="$MODEL_DIR/${MODULE_NAME^}Model.php"
echo "<?php

namespace App\Models;

use CodeIgniter\Model;

class ${MODULE_NAME^}Model extends Model
{
    protected \$table = '$MODULE_NAME';
    protected \$primaryKey = 'id';
}" > $MODEL_FILE

# Generar archivo de vista
VIEW_FILE="$VIEW_DIR/index.php"
echo "<h1>Vista de $MODULE_NAME</h1>" > $VIEW_FILE

# Generar archivo JS
JS_FILE="$JS_DIR/${MODULE_NAME}.js"
echo "console.log('$MODULE_NAME JavaScript file');" > $JS_FILE

echo "Módulo '$MODULE_NAME' creado con éxito."
