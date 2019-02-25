<?php
namespace App\Services;

class Kursi
{
	protected $data = array();
	protected $kursi;
	protected $allocated = 0;
	protected $divisor = array();
	protected $divided = array();
	protected $hasil = array();

	public function __construct($data, $kursi, $divisor)
	{
		$this->data = $data;
		$this->kursi = $kursi;
		$this->divisor = $divisor;
		$this->prepareForAllocation();
	}

	public function divide()
	{
		$i = 0;
		while($i < count($this->divisor))
		{
			foreach ($this->data as $key => $value) 
			{
				$this->divided[$this->divisor[$i]][$key] = (int)$value/$this->divisor[$i];
			}

			$i++;
		}

		return $this->divided;
	}

	public function prepareForAllocation()
	{
		foreach ($this->data as $key => $value) 
		{
			$this->hasil['kursi'][$key] = 0;
		}
	}

	public function order($divided)
	{
		$ordered = [];
		foreach ($divided as $div => $partai) 
		{
			foreach ($partai as $part => $value) 
			{
				$ordered[] = $value;
			}
		}

		return $ordered;
	}

	public function calculateSeat()
	{
		while($this->allocated < $this->kursi)
		{
			$ordered = $this->order($this->divided);
			$get = max($ordered);
			foreach ($this->divided as $div => $part) 
			{
				if(array_search($get, $part))
				{
					$this->kursi--;
					$partai = array_search($get, $part);
					$this->hasil['kursi'][$partai] = $this->hasil['kursi'][$partai] + 1;
					unset($this->divided[$div][$partai]);
					break;
				}
			}

			unset($ordered);
		}
		return $this->hasil;
	}

	public function getResult()
	{
		return $this->hasil;
	}
}