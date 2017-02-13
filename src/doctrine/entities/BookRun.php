<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BookRun
 *
 * @ORM\Table(name="book_run", indexes={@ORM\Index(name="edition_id", columns={"edition_id"}), @ORM\Index(name="publisher_id", columns={"publisher_id"})})
 * @ORM\Entity
 */
class BookRun
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob", length=16777215, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="image_thumb", type="blob", length=16777215, nullable=true)
     */
    private $imageThumb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var \Edition
     *
     * @ORM\ManyToOne(targetEntity="Edition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="edition_id", referencedColumnName="id")
     * })
     */
    private $edition;

    /**
     * @var \Publisher
     *
     * @ORM\ManyToOne(targetEntity="Publisher")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     * })
     */
    private $publisher;


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
     * @return BookRun
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
     * Set imageThumb
     *
     * @param string $imageThumb
     *
     * @return BookRun
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;

        return $this;
    }

    /**
     * Get imageThumb
     *
     * @return string
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return BookRun
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return BookRun
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
     * Set edition
     *
     * @param \Edition $edition
     *
     * @return BookRun
     */
    public function setEdition(\Edition $edition = null)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * @return \Edition
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Set publisher
     *
     * @param \Publisher $publisher
     *
     * @return BookRun
     */
    public function setPublisher(\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return \Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }
}

