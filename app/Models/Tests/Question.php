<?php

namespace App\Models\Tests;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Question extends BaseModel {
	use SoftDeletes;
	
	protected $appends = ['preview', 'scenario', 'url', 'code'];
	protected $casts = [
		'show_text_recording' => 'boolean'
	];
	
	protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected static $logName = 'question';

	
	public function test() {
		return $this->belongsTo('App\Models\Tests\Test');
	}
	
	public function getPreviewAttribute() {
		if ($this->resource) {
			if (Storage::disk('local')->exists($this->resource)) {
				return "<img src=\"" . url('/') . Storage::disk('local')->url($this->resource) . "\" class=\"file-preview-image\"/>";
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
				
				
				return "<iframe width=\"400px\" height=\"240px\" src=\"{$source}{$code}\"></iframe>";
			}
		}
		
		return null;
	}
	
	public function getUrlAttribute() {
		if($this->scenario == 'image'){
			return action('Resources\ResourceController@question', ['question' => $this->id]);
		}
		
		return null;
	}
	
	public function getCodeAttribute() {
		preg_match("/\w*$/", $this->resource, $code);
		
		return $code[0];
	}
	
	public function answers() {
		return $this->hasMany(Answer::class);
	}
	
	/**
	 * Get the "scenario" attribute according to resource.
	 * @return string Name of the scenario: text, video, or image.
	 */
	public function getScenarioAttribute() {
		//If it is a image or a video, sets the correct scenario
		if ($this->resource !== 'text' && !empty($this->resource)) {
			if (Storage::disk('local')->exists($this->resource)) {
				return "image";
			}

			return "video";
		}
		
		return 'text';
	}

	public function resourceType() {

		if ($this->resource !== '') {
			if (Storage::exists($this->resource)) {
				return "image";
			}

			return 'external';
		}

		return null;

	}
}
