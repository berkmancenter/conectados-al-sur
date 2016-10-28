
///////////////////////////////////////////////////////////////////////////////
//////////////////// MISCELLANEOUS ////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function _useSpanish() {
    if (_language == "es") {
        return true;
    };
    return false;
}


///////////////////////////////////////////////////////////////////////////////
//////////////////// GET DATA HELPERS /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// generic data by id
function _getDataById(id, data, name) {
    var matches = $.grep(data, 
        function(e){
            return e.id == id;
        }
    );

    if (matches.length >0) {
        return matches[0];
    };
    if (name) { console.log("Attemped to use undefined data '" + name + "' (id:" + id + ")."); };
    return null;   
}

// continents
function getContinentById(id) {
    return _getDataById(id, _data_continents, 'continent');
}

// subcontinents
function getSubcontinentById(id) {
    return _getDataById(id, _data_subcontinents, 'subcontinent');
}

// countries
function getCountryById(id) {
    return _getDataById(id, _data_countries, 'country');
}

// genres
function getGenreById(id) {
    return _getDataById(id, _data_genres, 'genre');
}

// project_stages
function getProjectStageById(id) {
    return _getDataById(id, _data_project_stages, 'project_stage');
}

// categories
function getCategoryById(id) {
    return _getDataById(id, _data_categories, 'category');
}

// organization_types
function getOrganizationTypeById(id) {
    return _getDataById(id, _data_organization_types, 'organization_type');
}

// projects
function getProjectById(id) {
    return _getDataById(id, _data_projects, 'project');
}

// console.log(getProjectById(5));
// console.log(getContinentById(5));
// console.log(getSubcontinentById(14));
// console.log(getCountryById(152));
// console.log(getGenreById(1));
// console.log(getProjectStageById(1));
// console.log(getCategoryById(3));
// console.log(getOrganizationTypeById(1));



///////////////////////////////////////////////////////////////////////////////
//////////////////// PREPARE DATA /////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
function filterValidateOrganizationType(project, organization_type_id) {
    if (project.organization_type_id != organization_type_id) {
        return false;
    };
    return true;
}

function filterValidateCategory(project, category_id) {
    var has_category = project.categories.reduce(
        function (result, category) {
            match = category.id == category_id;
            return result || match;
        },
        false
    );
    if (!has_category) { return false; }
    return true;
}

function filterValidateProjectStage(project, project_stage_id) {
    if (project.project_stage_id != project_stage_id) {
        return false;
    };
    return true;
}

function filterValidateUserGenre(project, user_genre_id) {
    if (project.user.genre_id != user_genre_id) {
        return false;
    };
    return true;
}

function filterValidateRegion(project, region_id) {
    country = getCountryById(project.country_id);
    if (!country) { return; }
    // console.log(country);

    subcontinent = getSubcontinentById(country.subcontinent_id);
    if (! subcontinent) { return; }
    // console.log(subcontinent);

    if (subcontinent.continent_id != region_id) {
        return false;
    };
    return true
}

function filterValidateCountry(project, country_id) {
    if (project.country_id != country_id) {
        return false;
    };
    return true;
}


// create map with {country_id, project_ids_array}
function filterProjectsData(options) {

    // object version
    var filtered_projects = [];
    _data_projects.map(function (project, index) {
        // console.log(project);

        if (options.hasOwnProperty('organization_type_id') && !filterValidateOrganizationType(project, options.organization_type_id)) { return; }
        if (options.hasOwnProperty('category_id')          && !filterValidateCategory        (project, options.category_id         )) { return; }
        if (options.hasOwnProperty('project_stage_id')     && !filterValidateProjectStage    (project, options.project_stage_id    )) { return; }
        if (options.hasOwnProperty('user_genre_id')        && !filterValidateUserGenre       (project, options.user_genre_id       )) { return; }
        if (options.hasOwnProperty('region_id')            && !filterValidateRegion          (project, options.region_id           )) { return; }
        if (options.hasOwnProperty('country_id')           && !filterValidateCountry         (project, options.country_id          )) { return; }

        // ----------------------------------------------------------------
        // project is valid!
        return filtered_projects.push(project);
    });
    context.projects = filtered_projects;
    context.current_max_nodes = Math.min(filtered_projects.length, context.max_nodes);
}


function getCountryProjectIds(id) {
    country = _getDataById(id, actual_map_by_country, null);
    // console.log(id);
    // console.log(country);
    if (country) {
        return country.projects;
    };
    // console.log("Attemped to get projects from an inexistent country (id:" + id + ").");
    return null;
}
// console.log(getCountryProjectIds(152));



///////////////////////////////////////////////////////////////////////////////
//////////////////// MISCELLANEOUS ////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// "name"
// "name_es"

function getDataset(option) {
    if (option == "t") {
        return _data_categories;
    } else if (option == "t") {
        return _data_organization_types;
    } else if (option == "r") {
        return _data_continents;
    } else if (option == "g") {
        return _data_genres;
    } else if (option == "s") {
        return _data_project_stages;
    }
    console.log("invalid option: " + option);
    return null;
}

function getProjectPropertyIds(project, property) {
    if (property == "t") { 
        return project.categories.map(function (item, key) {
            return item.id;
        });

    } else if (property == "t") {
        return [project.organization_type_id];

    } else if (property == "r") {
        country_id = project.country_id;
        country = getCountryById(country_id);
        subcontinent = getSubcontinentById(country.subcontinent_id);
        return [subcontinent.continent_id];

    } else if (property == "g") {
        return [project.user.genre_id];

    } else if (property == "s") {
        return [project.project_stage_id];
    }
    console.log("invalid property: " + property);
    return null;
}




// -------------------------- parse form ---------------------------
function filterParseOptions() {
    
    var options = {};

    // organization type
    var orgtype = document.getElementById("filter-orgtype").value;
    if (orgtype) { options.organization_type_id = orgtype; };
    
    // category
    var category = document.getElementById("filter-category").value;
    if (category) { options.category_id = category; };

    // project_stage
    var stage = document.getElementById("filter-stage").value;
    if (stage) { options.project_stage_id = stage; };
    
    // user genre
    var genre = document.getElementById("filter-genre").value;
    if (genre) { options.user_genre_id = genre; };

    // region
    var region = document.getElementById("filter-region").value;
    if (region) { options.region_id = region; };

    // country
    var country = document.getElementById("filter-country").value;
    if (country) { options.country_id = country; };

    // console.log(options);
    return options;
}