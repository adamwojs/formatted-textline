<?= "<?php\n"; ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Type as FormattedTextLineType;

final class Type extends FormattedTextLineType
{
    public function getFieldTypeIdentifier(): string
    {
        return '<?= $identifier; ?>';
    }
}
