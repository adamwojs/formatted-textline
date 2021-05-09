<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\MVC\Symfony\Templating;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Value;
use AdamWojs\IbexaFormattedTextLineBundle\MVC\Symfony\Templating\FallbackFieldBlockRenderer;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\Core\MVC\Symfony\Templating\Exception\MissingFieldBlockException;
use eZ\Publish\Core\MVC\Symfony\Templating\FieldBlockRendererInterface;
use PHPUnit\Framework\TestCase;

final class FallbackFieldBlockRendererTest extends TestCase
{
    /** @var \eZ\Publish\Core\MVC\Symfony\Templating\FieldBlockRendererInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $innerFieldBlockRenderer;

    /** @var \AdamWojs\IbexaFormattedTextLineBundle\MVC\Symfony\Templating\FallbackFieldBlockRenderer */
    private $fallbackFieldBlockRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->innerFieldBlockRenderer = $this->createMock(FieldBlockRendererInterface::class);
        $this->fallbackFieldBlockRenderer = new FallbackFieldBlockRenderer($this->innerFieldBlockRenderer);
    }

    public function testRenderContentFieldViewForExistingBlock(): void
    {
        $expectedResult = '<content-field-view />';

        $args = [
            $this->createMock(Field::class),
            'field_identifier',
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ];

        $this->innerFieldBlockRenderer
            ->expects($this->once())
            ->method('renderContentFieldView')
            ->with(...$args)
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->fallbackFieldBlockRenderer->renderContentFieldView(...$args)
        );
    }

    public function testRenderContentFieldViewForNonExistingBlock(): void
    {
        $expectedResult = 'Lorem ipsum dolor, sit ament ...';

        $args = [
            new Field(['value' => new Value($expectedResult)]),
            'textline',
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ];

        $this->innerFieldBlockRenderer
            ->expects($this->once())
            ->method('renderContentFieldView')
            ->willThrowException($this->createMock(MissingFieldBlockException::class));

        $this->assertEquals(
            $expectedResult,
            $this->fallbackFieldBlockRenderer->RenderContentFieldView(...$args)
        );
    }

    public function testRenderContentFieldEdit(): void
    {
        $expectedResult = '<content-field-edit />';

        $args = [
            $this->createMock(Field::class),
            'field_identifier',
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ];

        $this->innerFieldBlockRenderer
            ->expects($this->once())
            ->method('renderContentFieldEdit')
            ->with(...$args)
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->fallbackFieldBlockRenderer->renderContentFieldEdit(...$args)
        );
    }

    public function testRenderFieldDefinitionView(): void
    {
        $expectedResult = '<field-definition-view />';

        $args = [
            $this->createMock(FieldDefinition::class),
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ];

        $this->innerFieldBlockRenderer
            ->expects($this->once())
            ->method('renderFieldDefinitionView')
            ->with(...$args)
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->fallbackFieldBlockRenderer->renderFieldDefinitionView(...$args)
        );
    }

    public function testRenderFieldDefinitionEdit(): void
    {
        $expectedResult = '<field-definition-view />';

        $args = [
            $this->createMock(FieldDefinition::class),
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ];

        $this->innerFieldBlockRenderer
            ->expects($this->once())
            ->method('renderFieldDefinitionEdit')
            ->with(...$args)
            ->willReturn($expectedResult);

        $this->assertEquals(
            $expectedResult,
            $this->fallbackFieldBlockRenderer->renderFieldDefinitionEdit(...$args)
        );
    }
}
