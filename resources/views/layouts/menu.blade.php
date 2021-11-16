
<li class="{{ Request::is('appUsers*') ? 'active' : '' }}">
    <a href="{{ route('appUsers.index') }}"><i class="fa fa-edit"></i><span>App Users</span></a>
</li>

<li class="{{ Request::is('userTokens*') ? 'active' : '' }}">
    <a href="{{ route('userTokens.index') }}"><i class="fa fa-edit"></i><span>User Tokens</span></a>
</li>

<li class="{{ Request::is('userSubscriptions*') ? 'active' : '' }}">
    <a href="{{ route('userSubscriptions.index') }}"><i class="fa fa-edit"></i><span>User Subscriptions</span></a>
</li>

