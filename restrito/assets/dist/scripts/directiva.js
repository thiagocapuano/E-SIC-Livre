'use strict';

//DIRETIVAS
angular.module('Retaguarda').directive('buttonwave', [function () {
  return {
    restrict: 'A',
    link: function link(scope, elem, attrs) {
      Waves.init();
      Waves.attach('.flat-icon', ['waves-circle']);
      Waves.attach('.button', ['waves-button', 'waves-float']);
    }
  };
}]);

angular.module('Retaguarda').directive('form', [function () {
  return {
    restrict: 'A',
    link: function link(scope, elem, attrs) {
      $(document).ready(function () {
        $('form .form-control').each(function () {
          if ($(this).val() !== '') $(this).parents('.form-group').addClass('active');
        });
        $('form .form-control').focus(function () {
          $(this).parents('.form-group').addClass('active');
        });
        $('form .form-control').blur(function () {
          if ($(this).val() === '') {
            $(this).parents('.form-group').removeClass('active');
          }
        });
      });
    }
  };
}]);
angular.module('Retaguarda').directive('dropdownBoot', [function () {
  return {
    restrict: 'A',
    link: function link(scope, elem, attrs) {
      $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
      });
    }
  };
}]);
angular.module('Retaguarda').directive('dropdown', [function () {
  return {
    restrict: 'A',
    link: function link(scope, elem, attrs) {
      $(document).ready(function () {
        $('.menu .dropdown a').click(function () {
          $(this).siblings('ul').slideToggle('fast');
        });
      });
    }
  };
}]);

angular.module('Retaguarda').directive('tabGoogle', [function () {
  return {
    restrict: 'A',
    link: function link(scope, elem, attrs) {}
  };
}]);
//# sourceMappingURL=directiva.js.map
