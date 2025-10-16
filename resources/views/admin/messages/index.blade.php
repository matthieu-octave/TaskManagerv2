@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Boîte de réception des messages</h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="width: 15%;">Date</th>
                                <th scope="col" style="width: 20%;">Nom</th>
                                <th scope="col" style="width: 20%;">Email</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $message)
                                <tr>
                                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->content }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun message pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
