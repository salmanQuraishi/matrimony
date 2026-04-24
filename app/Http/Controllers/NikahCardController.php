<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NikahCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NikahCardTemplate;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Api\MethodController;

class NikahCardController extends Controller
{
    public function cardlist($id)
    {
        $user = User::findOrFail($id);
        $cards = NikahCard::where('user_id', $id)->latest()->get();

        return view('nikah_cards.index', compact('cards', 'user'));
    }

    public function generateCardForm($id)
    {
        $user = User::findOrFail($id);

        $templates = NikahCardTemplate::where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('nikah_cards.generate', compact('user', 'templates'));
    }

    public function generate(Request $request, $id)
    {
        $request->validate([
            'template_function' => 'required|string',
            'template_name' => 'required|string',
            'template_path' => 'required|string',
        ]);

        $allowedFunctions = ['Template1', 'Template2', 'Template3'];

        $templateFunction = $request->template_function;
        $templateName = $request->template_name;
        $templatePathFromRequest = str_replace('\\', '/', $request->template_path);

        if (!in_array($templateFunction, $allowedFunctions)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid template function',
            ], 422);
        }

        if (!$templatePathFromRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Please select template',
            ], 422);
        }

        $template = public_path($templatePathFromRequest);

        if (!file_exists($template)) {
            return response()->json([
                'status' => false,
                'message' => 'Template image not found',
            ], 404);
        }

        $userData = json_decode(json_encode(MethodController::formatUserResponse($id)));

        if (!method_exists($this, $templateFunction)) {
            return response()->json([
                'status' => false,
                'message' => 'Template method not found',
            ], 404);
        }

        return $this->$templateFunction(
            $userData,
            $template,
            $templateName,
            $templatePathFromRequest
        );
    }

    private function Template1($userData, $template, $templateName, $templatePathFromRequest)
    {
        $img = Image::make($template);

        $fontRegular = public_path('fonts/PatrickHand-Regular.ttf');
        $fontBold = public_path('fonts/AlexBrush-Regular.ttf');
        $fontHindi = public_path('fonts/NotoSansDevanagari.ttf');

        $gold = '#E6C36A';
        $normalTextSize = 28;

        $formattedHeight = $this->formatHeight($userData->height ?? null);
        $complexionText = $this->getComplexionText($userData);
        $dobText = $this->getDobText($userData);
        $birthPlace = $userData->birthplace ?? '';
        $religionCaste = $this->getReligionCaste($userData);
        $mobile = !empty($userData->mobile) ? $this->maskMobile($userData->mobile) : '';
        $address = $userData->address ?? 'N/A';

        $this->insertProfileImage($img, $userData, 112, 535, 250);

        $this->fitCenterText($img, ucwords(strtolower($userData->name ?? '')), 630, 590, 520, $fontBold, 90, 55, $gold);

        $this->fitLeftText($img, $dobText, 690, 650, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $birthPlace, 690, 720, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $formattedHeight, 350, 855, 130, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $complexionText, 325, 908, 130, $fontHindi, $normalTextSize, 19, $gold);
        $this->fitLeftText($img, $religionCaste, 340, 965, 200, $fontRegular, $normalTextSize, 18, $gold);

        $this->fitLeftText($img, $userData->education->name ?? 'education', 750, 850, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $userData->occupation->name ?? 'occupation', 750, 933, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->father_name ?? 'Father Name', 335, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->brothers ?? 0), 400, 1180, 135, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->mother_name ?? 'Mother Name', 780, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->sisters ?? 0), 825, 1180, 125, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $mobile, 550, 1265, 290, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $address, 480, 1325, 350, $fontRegular, 24, 16, $gold);

        return $this->saveCard($img, $userData, $templateName, $templatePathFromRequest);
    }

    private function Template2($userData, $template, $templateName, $templatePathFromRequest)
    {
        $img = Image::make($template);

        $fontRegular = public_path('fonts/PatrickHand-Regular.ttf');
        $fontBold = public_path('fonts/AlexBrush-Regular.ttf');
        $fontHindi = public_path('fonts/NotoSansDevanagari.ttf');

        $gold = '#E6C36A';
        $normalTextSize = 28;

        $formattedHeight = $this->formatHeight($userData->height ?? null);
        $complexionText = $this->getComplexionText($userData);
        $dobText = $this->getDobText($userData);
        $birthPlace = $userData->birthplace ?? '';
        $religionCaste = $this->getReligionCaste($userData);
        $mobile = !empty($userData->mobile) ? $this->maskMobile($userData->mobile) : '';
        $address = $userData->address ?? 'N/A';

        $this->insertProfileImage($img, $userData, 112, 535, 250);

        $this->fitCenterText($img, ucwords(strtolower($userData->name ?? '')), 630, 590, 520, $fontBold, 90, 55, $gold);

        $this->fitLeftText($img, $dobText, 690, 650, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $birthPlace, 690, 720, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $formattedHeight, 350, 855, 130, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $complexionText, 325, 908, 130, $fontHindi, $normalTextSize, 19, $gold);
        $this->fitLeftText($img, $religionCaste, 340, 965, 200, $fontRegular, $normalTextSize, 18, $gold);

        $this->fitLeftText($img, $userData->education->name ?? 'education', 750, 850, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $userData->occupation->name ?? 'occupation', 750, 933, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->father_name ?? 'Father Name', 335, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->brothers ?? 0), 400, 1180, 135, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->mother_name ?? 'Mother Name', 780, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->sisters ?? 0), 825, 1180, 125, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $mobile, 550, 1265, 290, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $address, 480, 1325, 350, $fontRegular, 24, 16, $gold);

        return $this->saveCard($img, $userData, $templateName, $templatePathFromRequest);
    }

    private function Template3($userData, $template, $templateName, $templatePathFromRequest)
    {
        $img = Image::make($template);

        $fontRegular = public_path('fonts/PatrickHand-Regular.ttf');
        $fontBold = public_path('fonts/AlexBrush-Regular.ttf');
        $fontHindi = public_path('fonts/NotoSansDevanagari.ttf');

        $gold = '#E6C36A';
        $normalTextSize = 28;

        $formattedHeight = $this->formatHeight($userData->height ?? null);
        $complexionText = $this->getComplexionText($userData);
        $dobText = $this->getDobText($userData);
        $birthPlace = $userData->birthplace ?? '';
        $religionCaste = $this->getReligionCaste($userData);
        $mobile = !empty($userData->mobile) ? $this->maskMobile($userData->mobile) : '';
        $address = $userData->address ?? 'N/A';

        $this->insertProfileImage($img, $userData, 112, 535, 250);

        $this->fitCenterText($img, ucwords(strtolower($userData->name ?? '')), 630, 590, 520, $fontBold, 90, 55, $gold);

        $this->fitLeftText($img, $dobText, 690, 650, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $birthPlace, 690, 720, 250, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $formattedHeight, 350, 855, 130, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $complexionText, 325, 908, 130, $fontHindi, $normalTextSize, 19, $gold);
        $this->fitLeftText($img, $religionCaste, 340, 965, 200, $fontRegular, $normalTextSize, 18, $gold);

        $this->fitLeftText($img, $userData->education->name ?? 'education', 750, 850, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $userData->occupation->name ?? 'occupation', 750, 933, 180, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->father_name ?? 'Father Name', 335, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->brothers ?? 0), 400, 1180, 135, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $userData->mother_name ?? 'Mother Name', 780, 1115, 170, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $this->getFamilyCount($userData->sisters ?? 0), 825, 1180, 125, $fontRegular, $normalTextSize, $normalTextSize, $gold);

        $this->fitLeftText($img, $mobile, 550, 1265, 290, $fontRegular, $normalTextSize, $normalTextSize, $gold);
        $this->fitLeftText($img, $address, 480, 1325, 350, $fontRegular, 24, 16, $gold);

        return $this->saveCard($img, $userData, $templateName, $templatePathFromRequest);
    }

    private function getDobText($userData)
    {
        $age = $userData->age ?? null;

        $dob = !empty($userData->dob)
            ? date('d-m-Y', strtotime($userData->dob))
            : null;

        $parts = [];

        if ($dob) {
            $parts[] = $dob;
        }

        if ($age) {
            $parts[] = "Age: {$age}";
        }

        return implode(' | ', $parts);
    }

    private function getComplexionText($userData)
    {
        $complexion1 = $userData->complexion->name ?? null;
        $complexion2 = $userData->complexion->hindi_name ?? null;

        $complexionText = collect([
            $complexion1,
            $complexion2,
        ])->filter()->implode(' / ');

        return $complexionText ?: 'N/A';
    }

    private function getReligionCaste($userData)
    {
        return trim(
            ($userData->relegion->name ?? '') . ' / ' . ($userData->caste->name ?? ''),
            ' /'
        );
    }

    private function getFamilyCount($value)
    {
        return ($value > 0) ? $value : 'N/A';
    }

    private function saveCard($img, $userData, $templateName, $templatePathFromRequest)
    {
        $folder = public_path('nikah-card/generated');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $templateSlug = Str::slug($templateName ?: 'template');
        $fileName = Str::slug($userData->name ?: 'user') . '-' . $userData->id . '-' . $templateSlug . '.png';
        $savePath = $folder . '/' . $fileName;

        $img->save($savePath);

        $dbPath = 'nikah-card/generated/' . $fileName;

        $card = NikahCard::updateOrCreate(
            [
                'user_id' => $userData->id,
                'template_name' => $templateName,
            ],
            [
                'template_path' => $templatePathFromRequest,
                'card_path' => $dbPath,
                'card_name' => $fileName,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => $templateName . ' card generated successfully',
            'card_id' => $card->id,
            'redirect_url' => route('nikah-card.list', $userData->id),
        ]);
    }

    private function insertProfileImage($img, $userData, $x, $y, $size = 250)
    {
        if (!empty($userData->profile) && file_exists(public_path($userData->profile))) {
            $profilePath = public_path($userData->profile);

            $profile = Image::make($profilePath)->fit($size, $size);

            $mask = Image::canvas($size, $size);
            $mask->circle($size, $size / 2, $size / 2, function ($draw) {
                $draw->background('#ffffff');
            });

            $profile->mask($mask);

            $img->insert($profile, 'top-left', $x, $y);
        }
    }

    private function formatHeight($heightCm)
    {
        if (!$heightCm) {
            return '';
        }

        $inches = $heightCm / 2.54;
        $feet = floor($inches / 12);
        $remainingInches = round($inches % 12);

        return $feet . "'" . $remainingInches . '"';
    }

    public function download($id)
    {
        $card = NikahCard::findOrFail($id);
        $filePath = public_path($card->card_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found');
        }

        return response()->download($filePath, $card->card_name);
    }

    public function delete($id)
    {
        $card = NikahCard::findOrFail($id);
        $filePath = public_path($card->card_path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $card->delete();

        return response()->json([
            'status' => true,
            'message' => 'Card deleted successfully',
        ]);
    }

    private function fitCenterText($img, $text, $centerX, $y, $maxWidth, $fontFile, $startSize, $minSize, $color)
    {
        if (trim((string) $text) === '') {
            return;
        }

        $size = $startSize;

        while ($size >= $minSize) {
            $box = imagettfbbox($size, 0, $fontFile, $text);
            $textWidth = abs($box[2] - $box[0]);

            if ($textWidth <= $maxWidth) {
                break;
            }

            $size--;
        }

        for ($i = 0; $i < 2; $i++) {
            $img->text($text, $centerX + $i, $y, function ($font) use ($fontFile, $size, $color) {
                $font->file($fontFile);
                $font->size($size);
                $font->color($color);
                $font->align('center');
                $font->valign('middle');
            });
        }
    }

    private function fitLeftText($img, $text, $x, $y, $maxWidth, $fontFile, $startSize, $minSize, $color)
    {
        if (trim((string) $text) === '') {
            return;
        }

        $size = $startSize;

        while ($size >= $minSize) {
            $box = imagettfbbox($size, 0, $fontFile, $text);
            $textWidth = abs($box[2] - $box[0]);

            if ($textWidth <= $maxWidth) {
                break;
            }

            $size--;
        }

        for ($i = 0; $i < 2; $i++) {
            $img->text($text, $x + $i, $y, function ($font) use ($fontFile, $size, $color) {
                $font->file($fontFile);
                $font->size($size);
                $font->color($color);
                $font->align('left');
                $font->valign('top');
            });
        }
    }

    private function maskMobile($mobile)
    {
        $mobile = preg_replace('/\D/', '', $mobile);

        if (strlen($mobile) < 6) {
            return $mobile ?: '';
        }

        return substr($mobile, 0, 3) . 'XXXXX' . substr($mobile, -2);
    }
}