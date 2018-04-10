<tr>
    <td><?php echo e($id); ?></td>
    <td id='brokerageFloat<?php echo e($game); ?>'><?php echo e($game); ?></td>
    <td><select class="form-control" id="CommisionChoose<?php echo e($game); ?>">
        <option value="0">不抽佣</option>
        <option value="1">固定比例抽佣</option>
        <option value="2">浮动比例抽佣</option>
        </select></td>
    <td><input type="text" id="Commisionratedata<?php echo e($game); ?>" name="Commisionratedata<?php echo e($game); ?>" size="8" placeholder=""></td>
    <td><select class="form-control" id="WaterChoose<?php echo e($game); ?>">
        <option value="0">不抽水</option>
        <option value="1">固定比例抽水</option>
        <option value="2">浮动比例抽水</option>
        </select></td>
    <td><input type="text" id="Waterratedata<?php echo e($game); ?>" name="Waterratedata<?php echo e($game); ?>" size="8" placeholder="">
        <a href="#floatSettingModal" id="Waterconfig<?php echo e($game); ?>" modalTag="water" data-toggle="modal" class="btn btn-xs blue">浮动比例设置</a></td>
</tr>