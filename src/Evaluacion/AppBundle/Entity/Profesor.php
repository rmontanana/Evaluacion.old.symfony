<?php
/*****************************************************************************
 * AppBundle/Entity/Profesor.php
 * Entidad Profesor
 * (C) Copyright 2012 Ricardo Montañana <rmontanana@gmail.com>
 * This file is part of Evaluacion.
 * ***************************************************************************
 * Evaluacion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Evaluacion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Evaluacion (LICENSE file). 
 * If not, see <http://www.gnu.org/licenses/>
 * ***************************************************************************
 */
namespace Evaluacion\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Evaluacion\AppBundle\Entity\Profesor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Profesor implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=45)
     * @Assert\Email(message = "La dirección '{{value}}' no es válida.")
     */
    private $email;

    /**
     * @var string $usuario
     *
     * @ORM\Column(name="usuario", type="string", length=45)
     * @Assert\Regex(pattern = "^([a-zA-Z])[a-zA-Z_-]*[\w_-]*[\S]$|^([a-zA-Z])[0-9_-]*[\S]$|^[a-zA-Z]*[\S]$",
     *               message = "El nombre de usuario no es válido."
     *              )
     */
    private $usuario;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    
    /**
     * @var string $salt
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string $rol
     *
     * @ORM\Column(name="rol", type="string", length=20)
     * @Assert\Choice(choices = {"ROLE_USER", "ROLE_ADMIN"}, message = "Elige un rol válido.")
     */
    private $rol;

    /**
     * Grupos a los que imparte clase
     * @var \Doctrine\Common\Collections\ArrrayCollections $grupos 
     * @ORM\ManyToMany(targetEntity="Evaluacion\AppBundle\Entity\Grupo", inversedBy="profesores", cascade={"persist"})
     */
    protected $grupos;

    /**
     * Devuelve si el usuario pasado es igual al actual
     * @param UserInterface $usuario
     * @return boolean
     */
    public function equals(UserInterface $usuario)
    {
        return $this->getLogin() == $usuario->getLogin();
    }
    
    
    public function eraseCredentials()
    {
        
    }
    
    /**
     * Devuelve un array con los roles del profesor
     * @return array
     */
    public function getRoles()
    {
        return array($this->getRol());
    }
    
    /**
     * Devuelve el login
     * @return type 
     */
    public function getUsername()
    {
        return $this->getLogin();
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Deuelve el usuario
     * @return string
     */
    public function getLogin()
    {
        return $this->usuario;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Get salt
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * Establece la semilla
     * @param string $salt 
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Set rol
     *
     * @param string $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }
    
    /**
     * Devuelve la representación del profesor
     * @return string
     */
    public function __toString()
    {
        return $this->nombre;
    }
    
    /**
     * Constructor
     * @return type \Evaluacion\AppBundle\Entity\Profesor
     */
    public function __construct()
    {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add grupos
     *
     * @param Evaluacion\AppBundle\Entity\Grupo $grupo
     */
    public function addGrupo(\Evaluacion\AppBundle\Entity\Grupo $grupo)
    {
        $this->grupos[] = $grupo;
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }
}