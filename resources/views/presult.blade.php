<table class="table table-bordered">   
    <tr>
        <th>Email</th>
        <th>Subject</th>          
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->email }}</td>
        <td>{{ $product->subject }}</td>
    </tr>
    @endforeach
 </table>
    {!! $products->render() !!}