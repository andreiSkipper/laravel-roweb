@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <h1>
                <span class="fa fa-product-hunt faa-pulse animated"></span> Products
            </h1>
        </div>
        <?php
        /** @var \App\Http\Models\Products[] $products */
        foreach ($products as $product) {
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= $product->name ?>
                        <div class="pull-right">
                            Price: <?= $product->price ?> RON
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <?= $product->description ?>
                    </div>

                    <div class="panel-footer">
                        <h4 class="text-center">
                            <form method="POST" action="{{ route('carts-add') }}" id="form-{{ $product->id }}">
                                {{ csrf_field() }}

                                <div class="form-group hidden">
                                    <input id="product_id" type="text" class="form-control" name="product_id"
                                           value="{{ $product->id }}">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="cantity">Cantity:</label>
                                    <select class="form-control" name="cantity" id="cantity">
                                        <?php
                                        for ($i = 1; $i <= 50; $i++){
                                        ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php
                                        $i += $i >= 10 ? 4 : 0;
                                        }
                                        ?>
                                    </select>
                                    <div class="btn btn-success cart-add faa-parent animated-hover">
                                        <span class="fa fa-plus faa-tada"></span> Add to cart
                                    </div>
                                </div>
                            </form>
                        </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="row text-center">
            {{ $products->render() }}
        </div>
    </div>
@endsection