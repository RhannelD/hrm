<div class="contents-container col-md-10 offset-md-1">
    <div class="container">
        <div class="container card card-body my-5" id="form">
            <table class="table" id="table-info">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center bg-dark text-white">
                            <h1 class="my-auto font-weight-bold">
                                Department Info
                            </h1>
                        </th>
                    </tr>
                </thead>
                <tbody class="h4">
                    <tr> 
                        <td class="text-right col-3">Department:</td>
                        <td>{{$department->department}}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="py-0">
                            <div class="d-flex justify-content-end py-1">
                                <a href="{{ route('department') }}" class="btn btn-lg text-white btn-info" >Back</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
