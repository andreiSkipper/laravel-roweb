@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <h1>
                <span class="fa fa-shopping-cart faa-pulse animated"></span> Your Shopping Cart
            </h1>
        </div>
        <?php
        /** @var \App\Http\Models\Carts[] $carts */
        foreach ($carts as $cart) {
        ?>
        <div class="row cart" id="cart-{{ $cart->id }}">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= $cart->product->name ?>
                        <div class="pull-right">
                            Price: <?= $cart->product->price ?> RON
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <?= $cart->product->description ?>
                    </div>

                    <div class="panel-footer">
                        <h4 class="text-center">
                            <form method="POST" action="{{ route('carts-edit', ['id' => $cart->id]) }}"
                                  id="form-{{ $cart->id }}">
                                {{ csrf_field() }}

                                <div class="form-group hidden">
                                    <input id="id" type="text" class="form-control" name="id" value="{{ $cart->id }}">
                                </div>
                                <div class="form-group form-inline">
                                    <label>Cantity:</label>
                                    <select class="form-control" name="cantity" id="cantity">
                                        <?php
                                        for ($i = 1; $i <= 10; $i++){
                                        ?>
                                        <option value="<?= $i ?>" <?= $cart->cantity == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </h4>
                        <div class="btn btn-danger col-xs-12 faa-parent animated-hover" id="cart-delete">
                            <span class="fa fa-times faa-tada"></span> Delete
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="row text-center">
            {{ $carts->render() }}
        </div>
        <h1 class="text-center">
            Grand Total: <span id="cart-total"><?= \App\Http\Models\Carts::getTotal() ?></span> RON
        </h1>
    </div>
@endsection