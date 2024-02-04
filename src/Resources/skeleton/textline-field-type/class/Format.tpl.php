<?= "<?php\n"; ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format as FormatInterface;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;

final class Format implements FormatInterface
{
    public function validate(FieldDefinition $fieldDefinition, string $text): bool
    {
        return true;
    }

    public function getMask(FieldDefinition $fieldDefinition): ?string
    {
        return null;
    }

    public function getExamples(FieldDefinition $fieldDefinition): array
    {
        return [];
    }
}
