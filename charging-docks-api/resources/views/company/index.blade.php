
{{--<form action="{{route('administrator.authenticate')}}" method="post">--}}
@include ('headLayout');
<div class="sidebar">
    <a class="active" href="/company_list">List</a>
    <a href="/company_create">Add new</a>
</div>

<div class="content">
    <h2>Company list</h2>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Parent</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $company):?>
        <tr>

            <th scope="row">{{$company->id}}</th>
            <td>{{$company->name}}</td>
            <td>{{$company->parent_company_id}}</td>
            <td>
                <button type="button" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-primary">Update</button>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

