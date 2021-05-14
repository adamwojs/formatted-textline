<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\MaskedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\MaskedTextLine\Format;
use eZ\Publish\Core\Repository\Values\ContentType\FieldDefinition;
use PHPUnit\Framework\TestCase;

final class FormatTest extends TestCase
{
    private const EXAMPLE_MASK = '099.099.099.099';

    /** @var \AdamWojs\IbexaFormattedTextLineBundle\FieldType\MaskedTextLine\Format */
    private $format;

    protected function setUp(): void
    {
        $this->format = new Format();
    }

    /**
     * @dataProvider dataProviderForTestValidate
     */
    public function testValidate(string $mask, string $text, bool $expectedResult): void
    {
        $fieldDefinition = new FieldDefinition([
            'fieldSettings' => [
                'mask' => $mask,
            ],
        ]);

        $this->assertEquals(
            $expectedResult,
            $this->format->validate($fieldDefinition, $text)
        );
    }

    public function dataProviderForTestValidate(): iterable
    {
        yield 'empty mask' => ['', 'whatever', true];

        yield from $this->acceptsDigits('0', '9', 'A', 'a', 'C', 'c');
        yield from $this->rejectsDigits('L', '?');
        yield from $this->acceptsLetters('A', 'a', 'L', '?', 'C', 'c');
        yield from $this->rejectsLetters('0', '9');
        yield from $this->acceptsUnderscore('C', 'c');
        yield from $this->rejectsUnderscore('0', '9', 'A', 'a', 'L', '?', 'X', 'x');
        yield from $this->acceptsHexDigits('X', 'x');
        yield from $this->acceptsEmpty('9', '?', 'a', 'c', 'x');
        yield from $this->rejectsEmpty('0', 'L', 'A', 'C', 'X');
        yield from $this->rejectsSpecial('0', '9', 'A', 'a', 'L', '?', 'C', 'c', 'X', 'x');
    }

    public function testGetMask(): void
    {
        $fieldDefinition = new FieldDefinition([
            'fieldSettings' => [
                'mask' => self::EXAMPLE_MASK,
            ],
        ]);

        $this->assertEquals(
            self::EXAMPLE_MASK,
            $this->format->getMask($fieldDefinition)
        );
    }

    private function acceptsEmpty(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            yield sprintf('Format "%s" accepts empty text', $format) => [$format, '', true];
        }
    }

    private function rejectsEmpty(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            yield sprintf('Format "%s" rejects empty text', $format) => [$format, '', false];
        }
    }

    private function acceptsDigits(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getDigits() as $char) {
                yield sprintf('Format "%s" accepts digit "%s"', $format, $char) => [$format, $char, true];
            }
        }
    }

    private function rejectsDigits(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getDigits() as $char) {
                yield sprintf('Format "%s" rejects digit "%s"', $format, $char) => [$format, $char, false];
            }
        }
    }

    private function acceptsHexDigits(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getHexDigits() as $char) {
                yield sprintf('Format "%s" accepts hex digit "%s"', $format, $char) => [$format, $char, true];
            }
        }
    }

    private function acceptsLetters(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getLetters() as $char) {
                yield sprintf('Format "%s" accepts letter "%s"', $format, $char) => [$format, $char, true];
            }
        }
    }

    private function rejectsLetters(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getLetters() as $char) {
                yield sprintf('Format "%s" rejects letter "%s"', $format, $char) => [$format, $char, false];
            }
        }
    }

    private function acceptsUnderscore(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            yield sprintf('Format "%s" accepts underscore', $format) => [$format, '_', true];
        }
    }

    private function rejectsUnderscore(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            yield sprintf('Format "%s" rejects underscore', $format) => [$format, '_', false];
        }
    }

    private function acceptsSpecial(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getSpecialChars() as $char) {
                yield sprintf('Format "%s" accepts "%s"', $format, $char) => [$format, $char, true];
            }
        }
    }

    private function rejectsSpecial(string ...$formats): iterable
    {
        foreach ($formats as $format) {
            foreach ($this->getSpecialChars() as $char) {
                yield sprintf('Format "%s" rejects "%s"', $format, $char) => [$format, $char, false];
            }
        }
    }

    private function getDigits(): iterable
    {
        for ($i = 0; $i <= 9; ++$i) {
            yield (string)$i;
        }
    }

    private function getLetters(string $first = 'a', string $last = 'z'): iterable
    {
        for ($latter = ord($first); $latter <= ord($last); ++$latter) {
            yield chr($latter);
        }

        for ($latter = ord(strtoupper($first)); $latter <= ord(strtoupper($last)); ++$latter) {
            yield chr($latter);
        }
    }

    private function getHexDigits(): iterable
    {
        yield from $this->getDigits();
        yield from $this->getLetters('a', 'f');
    }

    private function getSpecialChars(): iterable
    {
        yield from str_split('!@#$%^&*()+{}:"|<>?;[]=-\'\\');
    }
}
