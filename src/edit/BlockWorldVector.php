<?php

namespace edit;

class BlockWorldVector extends WorldVector{

	public function equals($obj){
		if(!($obj instanceof Vector)){
			return false;
		}

		return (int) $obj->getX() == (int) $this->getX() && (int) $obj->getY() == (int) $this->getY() && (int) $obj->getZ() == (int) $this->getZ();
	}

	public function hashCode(){
		return ((int) $this->x << 19) ^
			((int) $this->y << 12) ^
			(int) $this->z;
	}
}