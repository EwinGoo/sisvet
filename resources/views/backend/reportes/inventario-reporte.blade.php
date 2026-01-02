<link rel="stylesheet" href="assets/css/normalize.css">
@php

@endphp

<style>
    @page {
        size: letter;
        /* Puedes cambiarlo a otro tamaño si es necesario */
        margin: 0;
        /* Quitar márgenes predeterminados */
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
</style>


<header>
    <h1>Reporte de Ejemplo</h1>
</header>
<img src="assets/images/banner6.jpg" alt="" width="100" height="50">

<h1>Hola Edwin</h1>
<table cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Paterno</th>
            <th>Materno</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ([1, 2, 3, 4, 5] as $item)
            <tr>
                <td style="max-width: 40px; overflow: hidden;padding: 10px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, praesentium?</td>
                <td>{{ $item }}</td>
                <td>{{ $item }}</td>
                <td>{{ $item }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<style>
    h1 {
        color: red;
    }

    h1 {
        color: aqua
    }
    table{
        /* border: 1px solid yellow; */
    }
    table tbody tr td,
    table thead tr th{
        border: 1px solid yellow;
        padding: 0;
        margin: 0
    }


    table thead {
        color: red;
        background-color: black;
        border-collapse: collapse;
        border: none;

    }

    th {
        border: none;
        background-color: red;
        border-radius: 10px;
        color: #fff;
    }

    img {
        border-radius: 10px;
    }

    h1 {
        padding: 0;
        margin: 0;
    }
</style>
