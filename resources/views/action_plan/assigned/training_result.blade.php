{{-- <div class="row">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => "Entranamientos",
            // 'url'   => route('departments.create'),
            // 'create'=> __('department.create_department')
            ])
        </div>
    </div> --}}
    <div class="row mt-5 col-md-12">
        <div class="col-xs-12 col-sm-8 col-md-12">
            <h2>Resultados de los Entrenamientos</h2>
            <table class="table">
                <thead class="mythead">
                <tr>
                    <th scope="col" class="myth">Pregunta</th>
                    <th scope="col" class="myth">Respuesta</th>
                    <th scope="col" class="myth">Evaluador</th>
                    <th scope="col" class="myth">Fecha evaluación</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        {{-- {{dd($question)}} --}}
                        @foreach($question->answer() as $answer)
                            <tr>
                                <td>{{$question->title}}</td>
                                <td>{{$answer->value}}</td>
                                <td>{{$answer->email}}</td>
                                <td>{{$answer->created_at}}</td>
                                </tr>
                        @endforeach
                        
                     @endforeach

                </tbody>
            </table>
        </div>
    </div>