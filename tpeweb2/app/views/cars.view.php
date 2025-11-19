<?php

class carsView
{
    public function displayCars($cars,$user)
    {
        require './templates/cars/lista_cars.phtml';
    }

    public function displayCarsDetalle($car,$user)
    {
        require './templates/cars/detalle_cars.phtml';
    }
    public function displayAddCarsForm($marcas,$user)
    {
        // La variable $marcas estará disponible dentro de form_alta.phtml
        require './templates/cars/form_addCar.phtml';
    }
    public function showError($error,$user=null)
    {
        echo "<h1>$error</h1>";
    }

}

?>