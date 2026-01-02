<!DOCTYPE html>
<html>
<head>
    <title>Reporte PDF</title>
    <style>
        @page {
            size: letter; /* Tamaño carta */
            margin: 10mm; /* Márgenes alrededor del documento */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 18px;
            background-color: #f3f3f3;
            padding: 5mm;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            padding: 5mm;
        }

        .content {
            margin-top: 30mm; /* Para asegurar que el contenido no se solape con el encabezado */
            padding-bottom: 20mm; /* Para dejar espacio para el pie de página */
        }

        .page-number {
            position: fixed;
            bottom: 10mm;
            right: 10mm;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Encabezado de la página -->
    <header>
        <h1>Reporte de Ejemplo</h1>
    </header>

    <!-- Contenido del reporte -->
    <div class="content">
        <p>Este es el contenido del reporte. Agrega más contenido aquí...</p>
        <p>Este es otro contenido de ejemplo. Agrega más párrafos...</p>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit facere deleniti eius, nobis nam itaque alias quas modi, in exercitationem velit a dicta delectus sed? Quo optio deleniti itaque tenetur?
            Quidem facilis adipisci odit earum, saepe commodi veritatis quasi qui pariatur. Fugiat fuga eos, cupiditate doloribus, et incidunt quidem corrupti molestias veniam, quae vitae quod. Maxime dignissimos in cum odio.
            Unde dicta laboriosam facilis autem distinctio labore exercitationem obcaecati, nesciunt numquam voluptate, nisi placeat odit aliquam! Quaerat, molestiae sequi ipsum, ipsam earum similique in et, error asperiores omnis dolorum! Harum.
            Quibusdam ipsa quam deserunt accusamus repellat quod, laborum nostrum. Earum voluptas blanditiis dolorem porro voluptatum atque laboriosam, numquam voluptatibus ut. Animi doloremque quos perferendis asperiores voluptatibus cumque harum error non.
            Mollitia asperiores et sapiente libero labore. Accusantium deleniti soluta, possimus commodi dolorum cupiditate a. Voluptas optio error, ipsa officia aliquid excepturi laboriosam provident architecto facere eum. Hic ea accusantium corporis!
            Itaque quia magni obcaecati beatae sequi, non praesentium ullam, ratione fugiat iure harum. Sit voluptates nostrum consequatur reiciendis illo labore, dolores nam, dolorem enim eos perspiciatis beatae illum, nobis doloremque.
            Provident perspiciatis optio qui totam dolor perferendis ex officia eaque sapiente, praesentium animi fugiat id in eum libero modi nam fuga, tenetur vitae iusto natus. Accusamus, quibusdam. Rerum, ipsam excepturi.
            Officiis unde autem asperiores at distinctio recusandae nihil ad facere reprehenderit, facilis vitae rem aliquid ex impedit amet possimus fugiat tenetur alias earum! Deleniti consequatur nostrum laboriosam totam, veritatis saepe.
            Quia sapiente temporibus reprehenderit qui nostrum nemo nesciunt natus recusandae laborum, eveniet dignissimos aut placeat tenetur amet architecto excepturi atque suscipit exercitationem enim ad odio voluptate asperiores accusamus. Aliquam, molestiae?
            Dicta voluptas reprehenderit nisi fuga voluptatum laborum quo nam provident iusto rem, enim similique cum, atque obcaecati nostrum deserunt sed accusantium? Tempore natus et assumenda optio quasi! Error, eos voluptates.
        </p>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit facere deleniti eius, nobis nam itaque alias quas modi, in exercitationem velit a dicta delectus sed? Quo optio deleniti itaque tenetur?
            Quidem facilis adipisci odit earum, saepe commodi veritatis quasi qui pariatur. Fugiat fuga eos, cupiditate doloribus, et incidunt quidem corrupti molestias veniam, quae vitae quod. Maxime dignissimos in cum odio.
            Unde dicta laboriosam facilis autem distinctio labore exercitationem obcaecati, nesciunt numquam voluptate, nisi placeat odit aliquam! Quaerat, molestiae sequi ipsum, ipsam earum similique in et, error asperiores omnis dolorum! Harum.
            Quibusdam ipsa quam deserunt accusamus repellat quod, laborum nostrum. Earum voluptas blanditiis dolorem porro voluptatum atque laboriosam, numquam voluptatibus ut. Animi doloremque quos perferendis asperiores voluptatibus cumque harum error non.
            Mollitia asperiores et sapiente libero labore. Accusantium deleniti soluta, possimus commodi dolorum cupiditate a. Voluptas optio error, ipsa officia aliquid excepturi laboriosam provident architecto facere eum. Hic ea accusantium corporis!
            Itaque quia magni obcaecati beatae sequi, non praesentium ullam, ratione fugiat iure harum. Sit voluptates nostrum consequatur reiciendis illo labore, dolores nam, dolorem enim eos perspiciatis beatae illum, nobis doloremque.
            Provident perspiciatis optio qui totam dolor perferendis ex officia eaque sapiente, praesentium animi fugiat id in eum libero modi nam fuga, tenetur vitae iusto natus. Accusamus, quibusdam. Rerum, ipsam excepturi.
            Officiis unde autem asperiores at distinctio recusandae nihil ad facere reprehenderit, facilis vitae rem aliquid ex impedit amet possimus fugiat tenetur alias earum! Deleniti consequatur nostrum laboriosam totam, veritatis saepe.
            Quia sapiente temporibus reprehenderit qui nostrum nemo nesciunt natus recusandae laborum, eveniet dignissimos aut placeat tenetur amet architecto excepturi atque suscipit exercitationem enim ad odio voluptate asperiores accusamus. Aliquam, molestiae?
            Dicta voluptas reprehenderit nisi fuga voluptatum laborum quo nam provident iusto rem, enim similique cum, atque obcaecati nostrum deserunt sed accusantium? Tempore natus et assumenda optio quasi! Error, eos voluptates.
        </p>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit facere deleniti eius, nobis nam itaque alias quas modi, in exercitationem velit a dicta delectus sed? Quo optio deleniti itaque tenetur?
            Quidem facilis adipisci odit earum, saepe commodi veritatis quasi qui pariatur. Fugiat fuga eos, cupiditate doloribus, et incidunt quidem corrupti molestias veniam, quae vitae quod. Maxime dignissimos in cum odio.
            Unde dicta laboriosam facilis autem distinctio labore exercitationem obcaecati, nesciunt numquam voluptate, nisi placeat odit aliquam! Quaerat, molestiae sequi ipsum, ipsam earum similique in et, error asperiores omnis dolorum! Harum.
            Quibusdam ipsa quam deserunt accusamus repellat quod, laborum nostrum. Earum voluptas blanditiis dolorem porro voluptatum atque laboriosam, numquam voluptatibus ut. Animi doloremque quos perferendis asperiores voluptatibus cumque harum error non.
            Mollitia asperiores et sapiente libero labore. Accusantium deleniti soluta, possimus commodi dolorum cupiditate a. Voluptas optio error, ipsa officia aliquid excepturi laboriosam provident architecto facere eum. Hic ea accusantium corporis!
            Itaque quia magni obcaecati beatae sequi, non praesentium ullam, ratione fugiat iure harum. Sit voluptates nostrum consequatur reiciendis illo labore, dolores nam, dolorem enim eos perspiciatis beatae illum, nobis doloremque.
            Provident perspiciatis optio qui totam dolor perferendis ex officia eaque sapiente, praesentium animi fugiat id in eum libero modi nam fuga, tenetur vitae iusto natus. Accusamus, quibusdam. Rerum, ipsam excepturi.
            Officiis unde autem asperiores at distinctio recusandae nihil ad facere reprehenderit, facilis vitae rem aliquid ex impedit amet possimus fugiat tenetur alias earum! Deleniti consequatur nostrum laboriosam totam, veritatis saepe.
            Quia sapiente temporibus reprehenderit qui nostrum nemo nesciunt natus recusandae laborum, eveniet dignissimos aut placeat tenetur amet architecto excepturi atque suscipit exercitationem enim ad odio voluptate asperiores accusamus. Aliquam, molestiae?
            Dicta voluptas reprehenderit nisi fuga voluptatum laborum quo nam provident iusto rem, enim similique cum, atque obcaecati nostrum deserunt sed accusantium? Tempore natus et assumenda optio quasi! Error, eos voluptates.
        </p>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit facere deleniti eius, nobis nam itaque alias quas modi, in exercitationem velit a dicta delectus sed? Quo optio deleniti itaque tenetur?
            Quidem facilis adipisci odit earum, saepe commodi veritatis quasi qui pariatur. Fugiat fuga eos, cupiditate doloribus, et incidunt quidem corrupti molestias veniam, quae vitae quod. Maxime dignissimos in cum odio.
            Unde dicta laboriosam facilis autem distinctio labore exercitationem obcaecati, nesciunt numquam voluptate, nisi placeat odit aliquam! Quaerat, molestiae sequi ipsum, ipsam earum similique in et, error asperiores omnis dolorum! Harum.
            Quibusdam ipsa quam deserunt accusamus repellat quod, laborum nostrum. Earum voluptas blanditiis dolorem porro voluptatum atque laboriosam, numquam voluptatibus ut. Animi doloremque quos perferendis asperiores voluptatibus cumque harum error non.
            Mollitia asperiores et sapiente libero labore. Accusantium deleniti soluta, possimus commodi dolorum cupiditate a. Voluptas optio error, ipsa officia aliquid excepturi laboriosam provident architecto facere eum. Hic ea accusantium corporis!
            Itaque quia magni obcaecati beatae sequi, non praesentium ullam, ratione fugiat iure harum. Sit voluptates nostrum consequatur reiciendis illo labore, dolores nam, dolorem enim eos perspiciatis beatae illum, nobis doloremque.
            Provident perspiciatis optio qui totam dolor perferendis ex officia eaque sapiente, praesentium animi fugiat id in eum libero modi nam fuga, tenetur vitae iusto natus. Accusamus, quibusdam. Rerum, ipsam excepturi.
            Officiis unde autem asperiores at distinctio recusandae nihil ad facere reprehenderit, facilis vitae rem aliquid ex impedit amet possimus fugiat tenetur alias earum! Deleniti consequatur nostrum laboriosam totam, veritatis saepe.
            Quia sapiente temporibus reprehenderit qui nostrum nemo nesciunt natus recusandae laborum, eveniet dignissimos aut placeat tenetur amet architecto excepturi atque suscipit exercitationem enim ad odio voluptate asperiores accusamus. Aliquam, molestiae?
            Dicta voluptas reprehenderit nisi fuga voluptatum laborum quo nam provident iusto rem, enim similique cum, atque obcaecati nostrum deserunt sed accusantium? Tempore natus et assumenda optio quasi! Error, eos voluptates.
        </p>
    </div>

    <!-- Pie de página con numeración -->
    <footer>
        <p>Mi pie de página - Reporte generado el {{ now() }}</p>
    </footer>

    <!-- Paginación (Número de página) -->
    <div class="page-number">
        Página {PAGE_NUM} de {PAGE_COUNT}
    </div>
</body>
</html>
