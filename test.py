import os
import requests

# Lista de URLs de los archivos de fuente
urls = [
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fCRc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fABc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fCBc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fBxc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fCxc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fChc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmSU5fBBc4.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu72xKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu5mxKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu7mxKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu4WxKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu7WxKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu7GxKOzY.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOmCnqEu92Fr1Mu4mxK.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fCRc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fABc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fCBc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fBxc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fCxc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fChc4EsA.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmEU9fBBc4.woff2",
"https://fonts.gstatic.com/s/roboto/v32/KFOlCnqEu92Fr1MmWUlfCRc4EsA.woff2",
    # Añade todas las URLs aquí...
]

# Carpeta destino para almacenar los archivos descargados
# Carpeta destino para almacenar los archivos descargados
download_path = "C:\\Users\\ealan\\Escritorio\\PROYECTOS\\1. SISVET\\public\\fonts\\typography"

# Crea la carpeta si no existe
os.makedirs(download_path, exist_ok=True)

# Descargar cada archivo de fuente
for url in urls:
    file_name = url.split("/")[-1]  # Obtener el nombre del archivo de la URL
    file_path = os.path.join(download_path, file_name)

    # Descargar y guardar el archivo
    response = requests.get(url)
    if response.status_code == 200:
        with open(file_path, "wb") as file:
            file.write(response.content)
        print(f"Descargado: {file_name}")
    else:
        print(f"Error al descargar {file_name}: {response.status_code}")

print("Descarga completa.")
