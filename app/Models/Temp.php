<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Temp extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path'
    ];

    public const TEMP = 'temp';

    /**
     * Move to public folder
     *
     * @param string $into
     * @return string
     */
    public function movePublicly(string $into): string
    {
        $newPath = str_replace(self::TEMP, $into, $this->path);

        Storage::move($this->path, 'public/'.$newPath);

        $this->selfDelete();

        return $newPath;
    }

    /**
     * Delete record
     *
     * @return void
     */
    private function selfDelete(): void
    {
        $this->delete();
    }
}
