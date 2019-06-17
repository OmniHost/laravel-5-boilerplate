<?php

Breadcrumbs::for('admin.stations.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Stations", route('admin.stations.index'));
});
Breadcrumbs::for('admin.stations.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Stations", route('admin.stations.index'));
	$trail->push("Add Station");
});

Breadcrumbs::for('admin.stations.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Stations", route('admin.stations.index'));
	$trail->push("Edit Station");
});

Breadcrumbs::for('admin.stations.profile', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push("Edit Station Profile");
});

Breadcrumbs::for('admin.contests.index', function ($trail, $station) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Contests", route('admin.contests.index', $station));
});

Breadcrumbs::for('admin.contests.create', function ($trail, $station) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Contests", route('admin.contests.index', $station));
	$trail->push("Add Contest", route('admin.contests.create', $station));
});


Breadcrumbs::for('admin.contests.edit', function ($trail, $station) {
	$trail->parent('admin.dashboard');
	$trail->push("Radio Contests", route('admin.contests.index', $station));
	$trail->push("Edit Contest");
});