<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown {{ @$sidenav['dashboard'] }}">
                <a href="{{ route('dashboard') }}" >
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Dashboard</span>

                </a>
            </li>
            <li class="nav-item dropdown {{ @$sidenav['emails'] }}">
                <a href="{{ route('email.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-mail"></i>
                    </span>
                    <span class="title">Emails</span>

                </a>
            </li>
            <li class="nav-item dropdown {{ @$sidenav['template'] }}">
                <a href="{{ route('template.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-box-plot"></i>
                    </span>
                    <span class="title">Template</span>

                </a>
            </li>

            <li class="nav-item dropdown {{ @$sidenav['mail_list'] }}">
                <a href="{{ route('maillist.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-unordered-list"></i>
                    </span>
                    <span class="title">Mail List</span>

                </a>
            </li>

            <li class="nav-item dropdown {{ @$sidenav['private_mail'] }}">
                <a href="{{ route('private.mail') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-mail"></i>
                    </span>
                    <span class="title">Private Mails</span>

                </a>
            </li>



            <li class="nav-item dropdown {{ @$sidenav['member'] }}">
                <a href="{{ route('member.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-user"></i>
                    </span>
                    <span class="title">Members</span>

                </a>
            </li>

            <li class="nav-item dropdown {{ @$sidenav['groups'] }}">
                <a href="{{ route('groups.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-usergroup-add"></i>
                    </span>
                    <span class="title">Groups</span>

                </a>
            </li>

            <li class="nav-item dropdown {{ @$sidenav['tasks'] }}">
                <a href="{{ route('tasks') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-tool"></i>
                    </span>
                    <span class="title">Tasks</span>

                </a>
            </li>

            {{--
                <li class="nav-item dropdown {{ @$sidenav['automate'] }}">
                    <a href="{{ route('automate') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-control"></i>
                        </span>
                        <span class="title">Automate</span>

                    </a>
                </li>
            --}}


            <li class="nav-item dropdown {{ @$sidenav['help'] }}">
                <a href="#">
                    <span class="icon-holder">
                        <i class="anticon anticon-question-circle"></i>
                    </span>
                    <span class="title">Help</span>

                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Side Nav END -->
