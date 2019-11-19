@extends('layouts.app')

@section('content')

    <!-- Trigger/Open The Modal -->
    <button id="createModalBtn">Add new journal</button>

    <br><br>

    <table width="100%" border="1px">
        <thead>
        <tr>
            <th width="70%"> name </th>
            <th width="70%"> action </th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))
            @foreach($data as $item)
                <tr>
                    <td> {{$item->name}} </td>
                    <td><a href="#" class="trigger__deleteJournal" data-id="{{$item->id}}">Delete this journal</a> </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>


    <!-- The Modal -->
    <div id="createModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- Modal header -->
            <div class="modal-header">
                <h3>Add new journal</h3>
            </div>
            <hr>
            <div class="modal-main">
                <form action="" method="post" enctype="multipart/form-data" class="saveJournal__form trigger__saveJournal">
                    <label for="name">
                        Enter journal name
                    </label>
                    <input type="text" id="name" name="name" required>
                    <br>
                    <label for="journal">
                        Upload PDF document
                    </label>
                    <input type="file" id="journal" name="journal" required>
                    <br>
                    <label for="poster">
                        Upload Poster
                    </label>
                    <input type="file" id="poster" name="poster" required>
                    <br>
                    <input type="submit" value="Save">
                </form>
            </div>

        </div>

    </div>

@endsection