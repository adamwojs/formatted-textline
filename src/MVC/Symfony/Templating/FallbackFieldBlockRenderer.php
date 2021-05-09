<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\MVC\Symfony\Templating;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Value;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\Core\MVC\Symfony\Templating\Exception\MissingFieldBlockException;
use eZ\Publish\Core\MVC\Symfony\Templating\FieldBlockRendererInterface;

final class FallbackFieldBlockRenderer implements FieldBlockRendererInterface
{
    /** @var \eZ\Publish\Core\MVC\Symfony\Templating\FieldBlockRendererInterface */
    private $innerFieldBlockRenderer;

    public function __construct(FieldBlockRendererInterface $innerFieldBlockRenderer)
    {
        $this->innerFieldBlockRenderer = $innerFieldBlockRenderer;
    }

    public function renderContentFieldView(Field $field, $fieldTypeIdentifier, array $params = [])
    {
        try {
            return $this->innerFieldBlockRenderer->renderContentFieldView(
                $field, $fieldTypeIdentifier, $params
            );
        } catch (MissingFieldBlockException $e) {
            if ($field->value instanceof Value) {
                // Use \eZ\Publish\SPI\FieldType\Value::__toString to render value
                return (string)$field->value;
            }

            throw $e;
        }
    }

    public function renderContentFieldEdit(Field $field, $fieldTypeIdentifier, array $params = [])
    {
        return $this->innerFieldBlockRenderer->renderContentFieldEdit($field, $fieldTypeIdentifier, $params);
    }

    public function renderFieldDefinitionView(FieldDefinition $fieldDefinition, array $params = [])
    {
        return $this->innerFieldBlockRenderer->renderFieldDefinitionView($fieldDefinition, $params);
    }

    public function renderFieldDefinitionEdit(FieldDefinition $fieldDefinition, array $params = [])
    {
        return $this->innerFieldBlockRenderer->renderFieldDefinitionEdit($fieldDefinition, $params);
    }

    public function __call($name, $arguments)
    {
        // In few places FieldBlockRendererInterface interface is NOT respected :(
        return $this->innerFieldBlockRenderer->$name(...$arguments);
    }
}
