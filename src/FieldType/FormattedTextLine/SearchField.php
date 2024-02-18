<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine;

use Ibexa\Contracts\Core\FieldType\Indexable;
use Ibexa\Contracts\Core\Persistence\Content\Field;
use Ibexa\Contracts\Core\Persistence\Content\Type\FieldDefinition;
use Ibexa\Contracts\Core\Search;

class SearchField implements Indexable
{
    public function getIndexData(Field $field, FieldDefinition $fieldDefinition): array
    {
        return [
            new Search\Field(
                'value',
                $field->value->data,
                new Search\FieldType\StringField()
            ),
            new Search\Field(
                'fulltext',
                $field->value->data,
                new Search\FieldType\FullTextField()
            ),
        ];
    }

    public function getIndexDefinition(): array
    {
        return [
            'value' => new Search\FieldType\StringField(),
        ];
    }

    public function getDefaultMatchField(): string
    {
        return 'value';
    }

    public function getDefaultSortField(): string
    {
        return $this->getDefaultMatchField();
    }
}
