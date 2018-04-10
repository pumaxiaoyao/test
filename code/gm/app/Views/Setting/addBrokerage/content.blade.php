<tr>
    <td>{{ $id }}</td>
    <td id='brokerageFloat{{ $game }}'>{{ $game }}</td>
    <td><select class="form-control" id="CommisionChoose{{ $game }}">
        <option value="0">不抽佣</option>
        <option value="1">固定比例抽佣</option>
        <option value="2">浮动比例抽佣</option>
        </select></td>
    <td><input type="text" id="Commisionratedata{{ $game }}" name="Commisionratedata{{ $game }}" size="8" placeholder=""></td>
    <td><select class="form-control" id="WaterChoose{{ $game }}">
        <option value="0">不抽水</option>
        <option value="1">固定比例抽水</option>
        <option value="2">浮动比例抽水</option>
        </select></td>
    <td><input type="text" id="Waterratedata{{ $game }}" name="Waterratedata{{ $game }}" size="8" placeholder="">
        <a href="#floatSettingModal" id="Waterconfig{{ $game }}" modalTag="water" data-toggle="modal" class="btn btn-xs blue">浮动比例设置</a></td>
</tr>