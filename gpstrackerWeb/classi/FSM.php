<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FSM
 *
 * @author francesco
 */
class FSM {

    public $from,$trueTo=null,$falseTo=null,$oggetto,$funzione,$esci=false,$breakPerDebug=false;
    
    
    public $fsm_state=null;
    public $stati=array();
    

    public function esegui() {
        global  $logger;


        if (count($this->stati)>0) {
            if ($this->fsm_state==null) {
                $this->fsm_state=$this->stati[0]->from;
            }        
        
            foreach ($this->stati as $stato) {            
                
                if ($this->fsm_state == $stato->from) {
                    
                    
                    $logger->info($stato->from);
                    if ($stato->breakPerDebug) {
                        $logger->info("BREAK");
                    }
                    
                    if ($stato->trueTo!=null && $stato->falseTo!=null) {
                    
                        if ($stato->oggetto!=null) {

                            $nomeFunzione=$stato->funzione;

                            if (  $stato->oggetto->$nomeFunzione()  ) {
                                $this->fsm_state=$stato->trueTo;
                                return $stato;
                            } else {
                                if (  $stato->falseTo !=null ) {
                                    $this->fsm_state=$stato->falseTo;
                                    return $stato;
                                }
                            }                         
                        }
                    } else {
                        return $stato;
                    }
                }
            }	
            return $stato;
        }       
        
        return null;
    }
    
    
    
    
}