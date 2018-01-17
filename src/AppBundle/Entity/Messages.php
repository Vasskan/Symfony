<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity
 */
class Messages
{
    /**
     * @var string
     * @Assert\Type("string")
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     */
    private $username;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     * @Assert\Url()
     * @ORM\Column(name="homepage", type="string", length=100, nullable=true)
     */
    private $homepage;

    /**
     * @var string
     * @Assert\Type("string")
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\Ip()
     * @ORM\Column(name="userip", type="string", nullable=false)
     */
    private $userip;

    /**
     * @var string
     * @Assert\Type("string")
     * @ORM\Column(name="browser", type="string", length=20, nullable=false)
     */
    private $browser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string")
     * @Assert\Image()
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="textfile", type="string")
     * @Assert\File(
     *     maxSize = "100k",
     *     mimeTypesMessage = "Please upload txt-file")
     */
    private $textfile;

    public function __construct()
    {
        $this->setDate(new \DateTime());
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Messages
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Messages
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
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
     * Set homepage
     *
     * @param string $homepage
     *
     * @return Messages
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Messages
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Messages
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userip
     *
     * @param integer $userip
     *
     * @return Messages
     */
    public function setUserip($userip)
    {
        $this->userip = $userip;

        return $this;
    }

    /**
     * Get userip
     *
     * @return integer
     */
    public function getUserip()
    {
        return $this->userip;
    }

    /**
     * Set browser
     *
     * @param string $browser
     *
     * @return Messages
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
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
     * Set image
     *
     * @param string $image
     *
     * @return Messages
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set textfile
     *
     * @param string $textfile
     *
     * @return Messages
     */
    public function setTextfile($textfile)
    {
        $this->textfile = $textfile;

        return $this;
    }

    /**
     * Get textfile
     *
     * @return string
     */
    public function getTextfile()
    {
        return $this->textfile;
    }
}
