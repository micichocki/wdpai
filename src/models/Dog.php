<?php
class Dog{
    private $name;
    private $breed;
    private $color;
    private $photoUrl;

    public function __construct(string $name, string $breed, string $color, string $photoUrl){
        $this->name = $name;
        $this->breed = $breed;
        $this->color = $color;
        $this->photoUrl = $photoUrl;
    }

    public function getName(){
        return $this->name;
    }


}