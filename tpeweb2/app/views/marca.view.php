<?php
class marcaView
{
    public function displayMarcas($marcas, $user)
    {
        require './templates/marcas/lista_marcas.phtml';
    }
    public function displayDetalleMarca($marca, $user)
    {
        require './templates/marcas/detalle_marcas.phtml';
    }

    public function displayAddMarcaForm($marcas, $user)
    {
        require './templates/marcas/form_addMarca.phtml';
    }

    public function showError($error, $user = null)
    {
        echo "<h1>$error</h1>";
    }

}

