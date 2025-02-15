<?php

namespace Database\Seeders;

use App\Models\PreguntaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preguntas = [
            // Cálculo
            ['pregunta' => 'Aprender estilos de pintura artística.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Cantar en coros.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en estudios jurídicos.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar con calculadoras.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender decoración.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Estudiar derecho constitucional.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Planificar la construcción de obras fluviales y marítimas.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Estudiar los ecosistemas de una región.', 'id_area' => 6, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a interpretar radiografías.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer esculturas.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Supervisar obras en construcción.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Organizar la producción en una industria química.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar el nivel de los precios.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Evaluar daños de edificios y viviendas.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a realizar pronósticos meteorológicos.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Construir puentes.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Resolver ecuaciones matemáticas.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar con equipos electrónicos.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Elaborar una crítica de una obra artística teatral o cinematográfica.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Reparar electrodomésticos.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar a estudiantes sobre técnicas de aprendizaje.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar audiencias o juicios.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Evaluar el estado de conexiones eléctricas.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a utilizar instrumental médico.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Colaborar en un periódico o revista escolar.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar matemática.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar en empresas constructoras.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar obras literarias.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar las propiedades de diversos metales.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a realizar análisis bioquímicos.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Conocer técnicas y materiales de dibujo artístico.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Leer biografías de personas famosas.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar sobre mitología.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar las causas de las enfermedades.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a tomar fotografías periodísticas.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar textos históricos.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar centros y movimientos sísmicos.', 'id_area' => 5, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar a niños.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar sobre cuidado de plantas.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender anatomía.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar el proceso de formación de las nubes.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Tomar declaraciones a testigos de un hecho delictivo.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Traducir documentos comerciales a otro idioma.', 'id_area' => 15, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Realizar análisis químicos de productos industriales.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar la constitución físico-química de los minerales.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar a dibujar o pintar.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar idiomas extranjeros.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer experimentos para desarrollar nuevas variedades de vegetales.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en centros médicos.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Musicalizar obras teatrales.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer artesanías.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Reconocer los diferentes instrumentos de una orquesta.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en un archivo histórico.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar las causas de la deserción escolar.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar problemas económicos internacionales.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar los factores que influyen sobre la producción agropecuaria.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Tocar un instrumento musical.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar a personas en juicios de divorcio.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Traducir artículos científicos a otro idioma.', 'id_area' => 15, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar sobre impuestos.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Supervisar las condiciones laborales de una empresa.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer cálculos numéricos.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Producir programas televisivos.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Controlar los planos de una obra en construcción.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar literatura.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender un idioma extranjero.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar acontecimientos históricos.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar a personas con inquietudes literarias.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar con elementos de geometría.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Leer partituras.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Concurrir a conciertos musicales.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a elaborar dietas para pacientes.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender a elaborar guiones para obras audiovisuales.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Diseñar unidades ópticas de automóviles.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar sobre cría de animales.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer notas para una radio.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender técnicas de dirección orquestal.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Realizar arreglos musicales.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Organizar las relaciones públicas de una empresa.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar temas de comercio internacional.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Aprender álgebra.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Asesorar sobre métodos de cultivo de plantas alimenticias.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Redactar anuncios publicitarios.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en ambientes rurales.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar el movimiento de los átomos.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar el empleo de la energía nuclear.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Armar y probar motores.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar acerca de especies frutícolas.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Diseñar vehículos de gran tamaño.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Ayudar a personas con problemas emocionales.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Diseñar obras de arquitectura.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar a adultos.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Leer obras literarias en otro idioma.', 'id_area' => 12, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Cuidar pacientes.', 'id_area' => 7, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Hacer pintura mural.', 'id_area' => 13, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar con telescopios.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Enseñar a personas con discapacidades.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Ayudar a personas con problemas laborales.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar el origen y evolución del sistema solar.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Organizar empresas.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Programar computadoras.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en cerámica.', 'id_area' => 3, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Comprender conversaciones en otro idioma.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Trabajar en un laboratorio de física.', 'id_area' => 2, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Defender a personas acusadas en un juicio.', 'id_area' => 9, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Componer música.', 'id_area' => 14, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Estudiar planes de desarrollo económico.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Organizar actividades recreativas para ancianos.', 'id_area' => 8, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar la atmósfera de otros planetas.', 'id_area' => 5, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Planificar actividades administrativas en empresas.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Investigar problemas matemáticos.', 'id_area' => 1, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Analizar la situación financiera de una empresa.', 'id_area' => 10, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Filmar películas documentales.', 'id_area' => 11, 'id_usuario' => 1, 'id_test' => 1],
            ['pregunta' => 'Armar circuitos eléctricos.', 'id_area' => 4, 'id_usuario' => 1, 'id_test' => 1],
        ];


        // Iterar sobre las áreas y guardarlas en la base de datos
        foreach ($preguntas as $pregunta) {
            PreguntaModel::create($pregunta);
        }
    }
}
