<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class DummyImageGenerator
{
  private array $palettes = [
    ['bg' => [232, 245, 233], 'accent' => [76, 175, 80], 'text' => [27, 94, 32]],
    ['bg' => [252, 228, 236], 'accent' => [233, 30, 99], 'text' => [136, 14, 79]],
    ['bg' => [255, 243, 224], 'accent' => [255, 152, 0], 'text' => [230, 81, 0]],
    ['bg' => [227, 242, 253], 'accent' => [33, 150, 243], 'text' => [13, 71, 161]],
    ['bg' => [243, 229, 245], 'accent' => [156, 39, 176], 'text' => [74, 20, 140]],
    ['bg' => [255, 248, 225], 'accent' => [212, 175, 55], 'text' => [109, 76, 0]],
  ];

  public function generate(string $relativePath, int $width, int $height, string $label, ?int $paletteIndex = null): string
  {
    $index = $paletteIndex ?? (crc32($label) % count($this->palettes));
    $palette = $this->palettes[$index % count($this->palettes)];
    $fullPath = storage_path('app/public/'.$relativePath);

    File::ensureDirectoryExists(dirname($fullPath));

    $image = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($image, ...$palette['bg']);
    $accent = imagecolorallocate($image, ...$palette['accent']);
    $textColor = imagecolorallocate($image, ...$palette['text']);
    $white = imagecolorallocatealpha($image, 255, 255, 255, 60);

    imagefilledrectangle($image, 0, 0, $width, $height, $bg);

    for ($i = 0; $i < 6; $i++) {
      $x = ($width / 6) * $i;
      imagefilledellipse($image, (int) $x, (int) ($height * 0.8), (int) ($width * 0.4), (int) ($height * 0.5), $white);
    }

    imagefilledellipse($image, (int) ($width * 0.5), (int) ($height * 0.42), (int) min($width, $height) * 0.28, (int) min($width, $height) * 0.28, $accent);
    imagefilledellipse($image, (int) ($width * 0.5), (int) ($height * 0.72), (int) min($width, $height) * 0.38, (int) min($width, $height) * 0.18, $accent);

    $this->drawCenteredText($image, $label, $width, $height, $textColor);

    imagejpeg($image, $fullPath, 88);
    imagedestroy($image);

    return $relativePath;
  }

  public function generateLogo(string $relativePath, string $text): string
  {
    $fullPath = storage_path('app/public/'.$relativePath);
    File::ensureDirectoryExists(dirname($fullPath));

    $width = 320;
    $height = 100;
    $image = imagecreatetruecolor($width, $height);
    imagesavealpha($image, true);
    imagealphablending($image, false);

    $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $transparent);
    imagealphablending($image, true);

    $green = imagecolorallocate($image, 46, 125, 50);
    imagefilledellipse($image, 42, 50, 56, 56, $green);
    imagestring($image, 5, 78, 38, $text, $green);

    imagepng($image, $fullPath);
    imagedestroy($image);

    return $relativePath;
  }

  public function generateFavicon(string $relativePath): string
  {
    $fullPath = storage_path('app/public/'.$relativePath);
    File::ensureDirectoryExists(dirname($fullPath));

    $size = 64;
    $image = imagecreatetruecolor($size, $size);
    $bg = imagecolorallocate($image, 232, 245, 233);
    $accent = imagecolorallocate($image, 76, 175, 80);
    imagefilledrectangle($image, 0, 0, $size, $size, $bg);
    imagefilledellipse($image, 32, 32, 44, 44, $accent);

    imagepng($image, $fullPath);
    imagedestroy($image);

    return $relativePath;
  }

  private function drawCenteredText($image, string $text, int $width, int $height, int $color): void
  {
    $font = 5;
    $maxChars = max(12, (int) ($width / 14));
    $lines = $this->wrapText($text, $maxChars);
    $lineHeight = imagefontheight($font) + 4;
    $totalHeight = count($lines) * $lineHeight;
    $startY = (int) (($height - $totalHeight) / 2) + (int) ($height * 0.08);

    foreach ($lines as $index => $line) {
      $textWidth = imagefontwidth($font) * strlen($line);
      $x = (int) (($width - $textWidth) / 2);
      $y = $startY + ($index * $lineHeight);
      imagestring($image, $font, $x, $y, $line, $color);
    }
  }

  private function wrapText(string $text, int $maxChars): array
  {
    $words = explode(' ', $text);
    $lines = [];
    $current = '';

    foreach ($words as $word) {
      $candidate = $current === '' ? $word : $current.' '.$word;
      if (strlen($candidate) <= $maxChars) {
        $current = $candidate;
      } else {
        if ($current !== '') {
          $lines[] = $current;
        }
        $current = $word;
      }
    }

    if ($current !== '') {
      $lines[] = $current;
    }

    return $lines ?: [$text];
  }
}
