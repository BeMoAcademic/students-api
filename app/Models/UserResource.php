<?php

namespace App\Models;

use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Storage;

class UserResource extends BaseModel {
	public $appends = [
		'text',
		'url',
		'code'
	];

    /**
     * @var string
     */
    protected static $logName = 'userResource';
	
	public function getTextAttribute() {
		return "{$this->type} - {$this->title}";
	}
	
	public function getPreviewAttribute() {
		if (Storage::disk('local')->exists($this->resource)) {
			$exploded = explode('/', $this->resource);
			$url = 'resource/pdf/' . array_pop($exploded);
			
			return "<iframe src='/pdf?file={$url}&amp;download=false&amp;print=false&amp;openfile=false' style='height: 75vh; width: 100%; max-width: 99%; padding: 0' allowfullscreen></iframe>";
		}
		
		if ($this->resource !== '') {
			if (stripos($this->resource, 'wistia') || stripos($this->resource, 'wi.st')) {
				$source = '//fast.wistia.net/embed/iframe/';
			} else if (stripos($this->resource, 'youtube') || stripos($this->resource, 'youtu.be')) {
				$source = '//www.youtube.com/embed/';
			} else if (stripos($this->resource, 'vimeo')) {
				$source = '//player.vimeo.com/video/';
			} else {
				$source = '';
			}
			
			preg_match("/[^=\/]+$/", $this->resource, $code);
			$code = $code[0];
			
			
			return "<iframe style='width: 100%; min-height: 350px' src='{$source}{$code}' id='resource_video_{$this->id}' allowfullscreen></iframe>";
		}
		
	}
	
	public function getUrlAttribute() {
		if ($this->resource) {
			return Storage::disk('local')->url($this->resource);
		}
		
		return false;
	}
	
	public function getCodeAttribute() {

		if (stripos($this->resource, 'youtube') || stripos($this->resource, 'youtu.be')) {
			preg_match("/[^=\/]+$/", $this->resource, $code);
		} else {
			preg_match("/\w*$/", $this->resource, $code);
		}
		
		return $code[0];
	}
	
	public function students() {
		return $this->belongsToMany(Student::class);
	}
}
