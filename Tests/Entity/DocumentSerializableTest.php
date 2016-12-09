<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 11:30
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Entity;
use Symfony\Component\VarDumper\VarDumper;
use Thuata\FrameworkBundle\Document\AbstractDocument;
use Thuata\FrameworkBundle\Entity\DocumentSerialization;
use Thuata\FrameworkBundle\Repository\Registry\MongoDBRegistry;
use Thuata\FrameworkBundle\Tests\Resources\Document\TestDocument;
use Thuata\FrameworkBundle\Tests\Resources\Entity\DocumentSerializableEntity;
use Thuata\FrameworkBundle\Tests\Resources\Manager\DocumentSerializableManager;
use Thuata\FrameworkBundle\Tests\Resources\Manager\ManagerFactoryMock;
use Thuata\FrameworkBundle\Tests\Traits\ReflectionTestTrait;


/**
 * Class DocumentSerializableTest
 *
 * @package   Thuata\FrameworkBundle\Tests\Entity
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class DocumentSerializableTest extends \PHPUnit_Framework_TestCase
{
    use ReflectionTestTrait;

    /**
     * testDocument
     *
     * @return TestDocument
     */
    public function testDocument()
    {
        $document = new TestDocument();

        $entity = new DocumentSerializableEntity();
        $entity->setInteger(1);
        $entity->setString('Some text');

        $document->setSerializableEntity($entity);

        $this->assertInstanceOf(DocumentSerializableEntity::class, $document->getSerializableEntity());

        return $document;
    }

    /**
     * testSerialization
     *
     * @param TestDocument $document
     *
     * @depends testDocument
     */
    public function testSerialization(TestDocument $document)
    {
        $entity = $document->getSerializableEntity();

        $this->assertInstanceOf(DocumentSerialization::class, $entity->documentSerialize());
    }

    /**
     * testDocumentDataInRegistry
     *
     * @param TestDocument $document
     *
     * @depends testDocument
     *
     * @return array
     */
    public function testDocumentDataInRegistry(TestDocument $document)
    {
        $registry = new MongoDBRegistry();

        $data = $this->invokeMethod($registry, 'getDocumentData', [$document]);

        $expected = [
            'serializableEntity' => [
                'document_serialization' => [
                    'manager_class' => DocumentSerializableManager::class,
                    'data' => [
                        'string' => 'Some text',
                        'integer' => 1
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $data);

        return $data;
    }

    /**
     * testDocumentPrepareForGet
     *
     * @param array $data
     *
     * @depends testDocumentDataInRegistry
     */
    public function testDocumentPrepareForGet(array $data)
    {
        $data = [
            'serializableEntity' => [
                'document_serialization' => [
                    'manager_class' => DocumentSerializableManager::class,
                    'data' => [
                        'string' => 'Some text',
                        'integer' => 1
                    ]
                ]
            ]
        ];

        $document = new TestDocument();

        $reflectionClass = new \ReflectionClass(AbstractDocument::class);

        $documentProperty = $reflectionClass->getProperty('document');
        $documentProperty->setAccessible(true);
        $documentProperty->setValue($document, $data);

        $manager = new DocumentSerializableManager();
        $manager->setFactory(new ManagerFactoryMock());
        $manager->setManagerFactory(new ManagerFactoryMock());

        $this->invokeMethod($manager, 'prepareEntityForGet', [$document]);

        $this->assertInstanceOf(DocumentSerializableEntity::class, $document->getSerializableEntity());
    }
}