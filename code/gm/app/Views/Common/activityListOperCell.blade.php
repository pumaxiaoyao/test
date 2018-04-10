<div class="btn-group">
    <a class="btn btn-xs green" href="#" data-toggle="dropdown">
        <i class="fa fa-user"></i> 操作 <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu">
        <li><a href="/activity/editActivity?actid={{ $actId }}"><i class="fa fa-edit"></i> 编辑</a></li>
        <li><a href="#" onclick='modifyStatus(this, {{ $actId }}, 1);'><i class="fa fa-plus"></i> 上架 </a></li>
        <li><a href="#" onclick='modifyStatus(this, {{ $actId }}, 2);'><i class="fa fa-trash-o"></i> 下架 </a></li>
        <li><a href="#" onclick='modifyStatus(this, {{ $actId }}, 3);'><i class="fa fa-times"></i> 删除 </a></li>
    </ul>
</div>