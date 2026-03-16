<div id="my_modal" class="modal  fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Charges</h4>
      </div>
      <div class="modal-body">
        <div class="well well-sm">
          <span> <strong class="glyphicon glyphicon-info-sign text-primary"></strong> Select charges you want...</span>
        </div>
        <div style="height:60%;overflow-y:auto;overflow-x: hidden;">

        <?php $isChecked = FALSE; ?>

           <ul class="list-group">
              <?php foreach($charges as $charge): ?>
                <li class="li-pump list-group-item list-group-sm row">

                  <?php foreach($pump_charges[$pump_id] as $pump_charge): ?>

                      <?php if ($pump_charge['charge_id'] == $charge->charge_id): ?>
                    
                        <span class="col-md-12 col-xs-12">
                           <div class="checkbox">
                            <label>
                              <input type="checkbox" value="<?= $charge->charge_id;?>" name='charges_input[]' class = "c_charges" checked>
                              <?= $charge->charge_desc; ?>
                            </label>
                          </div>
                        </span>
                        <span class="entry-collapse collapse">
                          <span class="col-md-3 col-xs-12">
                              <?php 
                                $val;
                                #display value by unit format
                                switch ($charge->unit) 
                                {
                                  case 'peso':
                                    # peso display format...
                                    $val = number_format((float)$pump_charge['value'],2,'.',',');
                                    break;

                                  default:
                                    # default...
                                    $val = round($pump_charge['value']);
                                    break;
                                }
                               ?>
                              <input type="text" class=" c_value form-control input-sm" placeholder="value" value="<?= $val; ?>">   
                          </span>
                          <span class="col-md-9 col-xs-12">
                              <input name="" id="" class="c_desc form-control input-sm" placeholder="description" value="<?= $pump_charge['desc']; ?>">
                          </span>
                        </span>

                      <?php $isChecked = TRUE; ?>
                      <?php break; ?>
                    <?php endif; ?>

                  <?php endforeach; ?>

                  <?php if ($isChecked == FALSE): ?>
                  
                      <span class="col-md-12 col-xs-12">
                         <div class="checkbox">
                          <label>
                            <input type="checkbox" value="<?= $charge->charge_id;?>" name='charges_input[]' class = "c_charges">
                            <?= $charge->charge_desc; ?>
                          </label>
                        </div>
                      </span>
                      <span class="entry-collapse collapse">
                        <span class="col-md-3 col-xs-12">
                            <input type="text" class=" c_value form-control input-sm" placeholder="value">   
                        </span>
                        <span class="col-md-9 col-xs-12">
                            <input name="" id="" class="c_desc form-control input-sm" placeholder="description" >
                        </span>
                      </span>
        
              <?php else: ?>
                <?php $isChecked = FALSE; ?>
              <?php endif ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_charge">Select</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
