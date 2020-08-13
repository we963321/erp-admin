<aside class="main-sidebar">

    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">欄目導航</li>
            
            <?php $comData=Request::get('comData_menu'); ?>
            @foreach($comData['top'] as $v)
                <li class="treeview  @if(in_array($v['id'],$comData['openarr'])) active @endif">
                    <a href="#"><i class="fa {{ $v['icon'] }}"></i> <span>{{$v['label']}}</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @foreach($comData[$v['id']] as $vv)
                            <li @if(in_array($vv['id'],$comData['openarr'])) class="active" @endif><a href="{{URL::route($vv['name'])}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>{{$vv['label']}}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

    </section>
</aside>