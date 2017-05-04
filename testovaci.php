<?php

abstract class Front_BasePresenter extends CommonBasePresenter {
    public $nastav;
    public $gal;
     public $zbo;
	/** Enable theme specific layout
	 */
      
  
    public function injectionSmes(SmesModel $nastav)
	{
		$this->nastav = $nastav;
	}

	public function formatLayoutTemplateFiles() {

		$list = parent::formatLayoutTemplateFiles();
		array_unshift($list, $this->context->params["wwwDir"] . "/theme/@layout.latte");
;
		return $list;
	}
 public function createComponentMyForm()
{
    $myform = new AppForm();
    $myform->getElementPrototype()->class('ajax');
    $myform->addText('hledat', 'Zadejte slovo:');
		$myform->addSubmit('submit1', 'Odeslat');
    $myform->onSuccess[] = callback($this, 'taskSubmitted');
    return $myform;
}
//odeslání
public function taskSubmitted(AppForm $myform)
{
    $values = (array) $myform->values;
		//handle additional input values
    $hledat=$values['hledat'];
		$values = $this->triggerEvent_filter('filterPageEditForm_values', $values);

    $this->nastav = HledatModel::addHledat($myform->values->hledat);
    if(!$this->isAjax()) $this->redirect('hledat:',$hledat);

}





	//send flashes with every AJAX response
	public function afterRender(){
	    if ($this->isAjax() && $this->hasFlashSession())
	        $this->invalidateControl('flashes');
          $this->invalidateControl('pytlik');
          $this->invalidateControl('namichat');
        // $this->invalidateControl('jazyk');
          

	}
/*	public function createComponentFlagsForm()
	{
		$form = new AppForm;
		$form->addImage('save','/theme/img/en.png');
		$form->onSuccess[] = callback($this, 'flagsFormSubmitted');
    return $form;
	}

public function flagsFormSubmitted(Form $form)
	{
	 // $values = (array) $form->values;

	  session_start();
	 $_SESSION["jazyk"]="en";

			$this->redirect('Menus:default');
	} 
		public function createComponentFlagscsForm()
	{
		$form = new AppForm;
		$form->addImage('save','/theme/img/cs.png');
		   $form->onSuccess[] = callback($this, 'flagscsFormSubmitted');
    return $form;
	}

public function flagscsFormSubmitted(Form $form)
	{
	 // $values = (array) $form->values;

	  session_start();
	 $_SESSION["jazyk"]="cs";

			$this->redirect('Pages:default');
	} 
 */ 
}
