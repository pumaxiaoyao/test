@foreach( $validGroups as $group )
<option value='{{ $group["id"] }}'>{{ $group["name"] }}</option>
@endforeach