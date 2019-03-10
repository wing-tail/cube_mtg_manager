<ul style="margin: 0; padding: 0; list-style: none;">
@foreach ($card_detail_list as $data)
    <li style="margin: 0; padding: 0; width: 223px; height: 311px; float: left;">
        <img src="{{ $data['image_url'] }}" style="width: 223px; margin: 0; padding: 0;">
    </li>
    @if ($loop->iteration % 4 == 0)
        </ul>
        <div style="clear: both;"></div>
        <ul style="margin: 0; padding: 0; list-style: none;">
    @endif
@endforeach
</ul>
<div style="clear: both;"></div>
<form action='save' method='post'>
    <input type='hidden' name='json' value='{{ $save_data }}'>
    <div>
        <input type='submit' value='save'>
    </div>
</form>
