<?php

namespace TvDb\Repo;

class TvDbActor
{

	public $id;
	public $image;
	public $name;
	public $role;
	public $sortOrder;
	public function __construct($data)
	{
		$this->id        = (int)$data->id;
		$this->image     = (string)$data->Image;
		$this->name      = (string)$data->Name;
		$this->role      = (string)$data->Role;
		$this->sortOrder = (int)$data->SortOrder;
	}

}