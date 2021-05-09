<?= "<?php\n"; ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format as FormatInterface;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

final class Format implements FormatInterface
{
    public function validate(FieldDefinition $fieldDefinition, string $text): bool
    {
        return true;
    }
}
