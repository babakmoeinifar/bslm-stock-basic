@if(allowed('stock'))
    {{--   stock    --}}
    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false">
            <i class="bi bi-clipboard2-data"></i>
            <span class="hide-menu ">سهام</span>
        </a>
        <ul aria-expanded="false" class="collapse  first-level">
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                   href="{{ url('admin/stock/trades') }}"
                   aria-expanded="false"><i class="fas fa-dollar-sign"></i>
                    <span class="hide-menu ">معاملات</span></a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                   href="{{ url('admin/stock/trades-history') }}"
                   aria-expanded="false"><i class="fas fa-dollar-sign"></i>
                    <span class="hide-menu ">گزارش معاملات مثقال</span></a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                   href="{{ url('admin/stock/esops') }}"
                   aria-expanded="false"><i class="fas fa-dollar-sign"></i>
                    <span class="hide-menu ">ESOPS</span></a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                   href="{{ url('admin/stock/symbolChanges') }}"
                   aria-expanded="false"><i class="fas fa-dollar-sign"></i>
                    <span class="hide-menu ">تغییرات نمادها</span></a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                   href="{{ url('admin/stock/symbol') }}"
                   aria-expanded="false"><i class="fas fa-dollar-sign"></i>
                    <span class="hide-menu ">نمادها</span></a>
            </li>


        </ul>
    </li>
@endif