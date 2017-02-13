<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookInstance
 *
 * @ORM\Table(name="book_instance", indexes={@ORM\Index(name="book_run_id", columns={"book_run_id"})})
 * @ORM\Entity
 */
class BookInstance
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @var \BookRun
     *
     * @ORM\ManyToOne(targetEntity="BookRun")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_run_id", referencedColumnName="id")
     * })
     */
    private $bookRun;


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return BookInstance
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return BookInstance
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set bookRun
     *
     * @param \BookRun $bookRun
     *
     * @return BookInstance
     */
    public function setBookRun(\BookRun $bookRun = null)
    {
        $this->bookRun = $bookRun;

        return $this;
    }

    /**
     * Get bookRun
     *
     * @return \BookRun
     */
    public function getBookRun()
    {
        return $this->bookRun;
    }
}
