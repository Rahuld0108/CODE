<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li>
        <?=$this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span>',['controller'=>'dashboard','action'=>'index'], ['class'=> 'silvermenu', 'title' => __('Dashboard'), 'escape' => false]);?>
    </li>
        <li class="treeview">
            <a href="#"><span>Article</span></a>
        </li>
</ul>
