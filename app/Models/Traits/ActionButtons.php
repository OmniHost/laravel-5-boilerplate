<?php

namespace App\Models\Traits;

trait ActionButtons
{

	   /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route($this->buttons['route'] . '.edit', $this).'" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route($this->buttons['route'] . '.destroy', $this).'"
			 data-method="delete"
			 data-trans-button-cancel="'.__('buttons.general.cancel').'"
			 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
			 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a> ';
    }

	/**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
		$return =  '<div class="btn-group btn-group-sm" role="group">';
		if($this->buttons['edit']) {
			$return .= $this->getEditButtonAttribute();
		}


		if($this->buttons['custom']){
			foreach($this->buttons['custom'] as $call){
				$return .= call_user_func([$this, $call]);
			}
		}

		if($this->buttons['delete']) {
			$return .= $this->getDeleteButtonAttribute();
		}

		$return .= '</div>';
		return $return;
    }
}