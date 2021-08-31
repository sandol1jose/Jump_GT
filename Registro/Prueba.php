
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
html,
body{
  align-items: center;
  background:#E8E8E8;
  box-sizing:border-box;
  color: #666;
  cursor: default;
  display: flex;
  font-family: sans-serif;
  height:100%;
  justify-content: center;
  margin:0;
  width:100%;
  -webkit-tap-highlight-color: transparent;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
*{
  box-sizing:inherit;
  cursor: inherit;
  transition-duration:.2s;
  transition-property:none;
  transition-timing-function:cubic-bezier(.42,0,.58,1)
}
label.field {
  border-radius: 2px;
  color: #666;
  display: block;
  margin: 16px;
  max-width: 300px;
  padding: 8px;
  opacity: 0;
  position: relative;
  transition-property: opacity;
  z-index: 1;
  span {
    color: inherit;
    display: block;
    font-size: 16px;
    height: 20px;
    line-height: 20px;
    left: 9px;
    pointer-events: none;
    position: absolute;
    top: 32px;
    transform: scale(1) translateY(0);
    transition-property: color, font-size, top;
    z-index: 1;
    &.required {
      &::after {
        color: inherit;
        content: "*";
        display: block;
        height: 20px;
        left: -20px;
        line-height: 20px;
        position: absolute;
        text-align: center;
        top: 0;
        width: 20px;
      }
    }
    .error & {
      color: #F02318
    }
  }
  .psuedo_select {
    background: rgba(255,255,255,0);
    position: relative;
    border-color: #666;
    border-style: solid;
    border-width: 0 0 2px 0;
    color: #666;
    cursor: pointer;
    font-size: 20px;
    height: 24px;
    line-height: 24px;
    margin: 24px 32px 0 0;
    min-width: 250px;
    padding-top: 24px;
    outline: 0;
    z-index: 1;
    &::after {
      background: url("data:image/svg+xml;utf8,<svg fill='#666' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'> <path d='M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z'/> <path d='M0-.75h24v24H0z' fill='none'/> </svg>"), no-repeat;
      content: "";
      height: 24px;
      width: 24px;
      position: absolute;
      top: 0;
      right: 0;
      transition-property: background;
    }
    .selected {
      height: 24px;
      left: 1px;
      line-height: 24px;
      opacity: 0;
      position: absolute;
      top: 0;
      transform: translateY(24px);
      transition-property: opacity, transform;
      will-change: transform;
    }
    ul {
      background: #fff;
      box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
      display: block;
      height: 0;
      list-style: none;
      margin-top: 2px;
      opacity: 0;
      overflow: hidden;
      padding: 0 1px;
      pointer-events: none;
      transition-property: height, opacity;
      width: 100%;
      z-index: 2;
      li {
        height: 32px;
        padding: 8px 4px;
      }
    }
  }
  .deselect {
    height: 100vh;
    left: 0;
    position: fixed;
    top: 0;
    width: 100vw;
    z-index: -1;
  }
  &.focused {
    color: #007BED;
    .psuedo_select {
      border-color: #007BED;
      &::after {
        background: url("data:image/svg+xml;utf8,<svg fill='#007BED' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'> <path d='M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z'/> <path d='M0-.75h24v24H0z' fill='none'/> </svg>"), no-repeat;
      }
      ul {
        opacity: 1;
        pointer-events: all;
      }
    }
  }
}

#gitHubButton {
  background: rgba(0,0,0,0.25);
  bottom: 10px;
  color: #FFF;
  font-size: 12px;
  padding: 5px;
  position: fixed;
  text-decoration: none;
  right: 10px;
}
  </style>
</head>
<body>

<label id="img_category_label"class="field"for="img_category"data-value="">
  <span>Category</span>
  <div id="img_category"class="psuedo_select"name="img_category">
    <span class="selected"></span>
    <ul id="img_category_options"class="options">
      <li class="option"data-value="opt_1">Option 1</li>
      <li class="option"data-value="opt_2">Option 2</li>
    </ul>
  </div>
</label>

<a id="gitHubButton" href="https://github.com/sammurphey/materialDesignElements" target="_blank">Fork on GitHub</a>

</body>
</html>


<script type="text/javascript">
   ////////////////////////////////////
  // prerequisite utility functions //
 // the real stuff starts below    //
////////////////////////////////////
var util = {
  f: {
    addStyle: function (elem, prop, val, vendors) {
      var i, ii, property, value
      if (!util.f.isElem(elem)) {
        elem = document.getElementById(elem)
      }
      if (!util.f.isArray(prop)) {
        prop = [prop]
        val = [val]
      }
      for (i = 0; i < prop.length; i += 1) {
        var thisProp = String(prop[i]),
          thisVal = String(val[i])
        if (typeof vendors !== "undefined") {
          if (!util.f.isArray(vendors)) {
            vendors.toLowerCase() == "all" ? vendors = ["webkit", "moz", "ms", "o"] : vendors = [vendors]
          }
          for (ii = 0; ii < vendors.length; ii += 1) {
            elem.style[vendors[i] + thisProp] = thisVal
          }
        }
        thisProp = thisProp.charAt(0).toLowerCase() + thisProp.slice(1)
        elem.style[thisProp] = thisVal
      }
    },
    cssLoaded: function (event) {
      var child = util.f.getTrg(event)
      child.setAttribute("media", "all")
    },
    events: {
      cancel: function (event) {
        util.f.events.prevent(event)
        util.f.events.stop(event)
      },
      prevent: function (event) {
        event = event || window.event
        event.preventDefault()
      },
      stop: function (event) {
        event = event || window.event
        event.stopPropagation()
      }
    },
    getSize: function (elem, prop) {
      return parseInt(elem.getBoundingClientRect()[prop], 10)
    },
    getTrg: function (event) {
      event = event || window.event
      if (event.srcElement) {
        return event.srcElement
      } else {
        return event.target
      }
    },
    isElem: function (elem) {
      return (util.f.isNode(elem) && elem.nodeType == 1)
    },
    isArray: function(v) {
      return (v.constructor === Array)
    },
    isNode: function(elem) {
      return (typeof Node === "object" ? elem instanceof Node : elem && typeof elem === "object" && typeof elem.nodeType === "number" && typeof elem.nodeName==="string" && elem.nodeType !== 3)
    },
    isObj: function (v) {
      return (typeof v == "object")
    },
    replaceAt: function(str, index, char) {
      return str.substr(0, index) + char + str.substr(index + char.length);
    }
  }
},
   //////////////////////////////////////
  // ok that's all the utilities      //
 // onto the select box / form stuff //
//////////////////////////////////////
form = {
f: {
  init: {
    register: function () {
      console.clear()// just cuz codepen
      var child, children = document.getElementsByClassName("field"), i
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        util.f.addStyle(child, "Opacity", 1)
      }
      children = document.getElementsByClassName("psuedo_select")
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        child.addEventListener("click", form.f.select.toggle)
      }
    },
    unregister: function () {
      //just here as a formallity
      //call this to stop all ongoing timeouts are ready the page for some sort of json re-route
    }
  },
  select: {
    blur: function (field) {
      field.classList.remove("focused")
      var child, children = field.childNodes, i, ii, nested_child, nested_children
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        if (util.f.isElem(child)) {
          if (child.classList.contains("deselect")) {
            child.parentNode.removeChild(child)
          } else if (child.tagName == "SPAN") {
            if (!field.dataset.value) {
              util.f.addStyle(child, ["FontSize", "Top"], ["16px", "32px"])
            }
          } else if (child.classList.contains("psuedo_select")) {
            nested_children = child.childNodes
            for (ii = 0; ii < nested_children.length; ii += 1) {
              nested_child = nested_children[ii]
              if (util.f.isElem(nested_child)) {
                if (nested_child.tagName == "SPAN") {
                  if (!field.dataset.value) {
                    util.f.addStyle(nested_child, ["Opacity", "Transform"], [0, "translateY(24px)"])
                  }
                } else if (nested_child.tagName == "UL") {
                    util.f.addStyle(nested_child, ["Height", "Opacity"], [0, 0])
                }
              }
            }
          }
        }
      }
    },
    focus: function (field) {
      field.classList.add("focused")
      var bool = false, child, children = field.childNodes, i, ii, iii, nested_child, nested_children, nested_nested_child, nested_nested_children, size = 0
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        util.f.isElem(child) && child.classList.contains("deselect") ? bool = true : null
      }
      if (!bool) {
        child = document.createElement("div")
        child.className = "deselect"
        child.addEventListener("click", form.f.select.toggle)
        field.insertBefore(child, children[0])
      }
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        if (util.f.isElem(child) && child.classList.contains("psuedo_select")) {
          nested_children = child.childNodes
          for (ii = 0; ii < nested_children.length; ii += 1) {
            nested_child = nested_children[ii]
            if (util.f.isElem(nested_child) && nested_child.tagName == "UL") {
              size = 0
              nested_nested_children = nested_child.childNodes
              for (iii = 0; iii < nested_nested_children.length; iii += 1) {
                nested_nested_child = nested_nested_children[iii]
                if (util.f.isElem(nested_nested_child) && nested_nested_child.tagName == "LI") {
                  size += util.f.getSize(nested_nested_child, "height")
                  console.log("size: " + size)
                }
              }
              util.f.addStyle(nested_child, ["Height", "Opacity"], [size + "px", 1])
            }
          }
        }
      }
    },
    selection: function (child, parent) {
      var children = parent.childNodes, i, ii, nested_child, nested_children, time = 0, value
      if (util.f.isElem(child) && util.f.isElem(parent)) {
        parent.dataset.value = child.dataset.value
        value = child.innerHTML
      }
      for (i = 0; i < children.length; i += 1) {
        child = children[i]
        if (util.f.isElem(child)) {
          if (child.classList.contains("psuedo_select")) {
            nested_children = child.childNodes
            for (ii = 0; ii < nested_children.length; ii += 1) {
              nested_child = nested_children[ii]
              if (util.f.isElem(nested_child) && nested_child.classList.contains("selected")) {
                if (nested_child.innerHTML)  {
                  time = 1E2
                  util.f.addStyle(nested_child, ["Opacity", "Transform"], [0, "translateY(24px)"], "all")
                }
                setTimeout(function (c, v) {
                  c.innerHTML = v
                  util.f.addStyle(c, ["Opacity", "Transform", "TransitionDuration"], [1, "translateY(0px)", ".1s"], "all")
                }, time, nested_child, value)
              }
            }
          } else if (child.tagName == "SPAN") {
            util.f.addStyle(child, ["FontSize", "Top"], ["12px", "8px"])
           }
         }
      }
    },
    toggle: function (event) {
      util.f.events.stop(event)
      var child = util.f.getTrg(event), children, i, parent
      switch (true) {
        case (child.classList.contains("psuedo_select")):
        case (child.classList.contains("deselect")):
          parent = child.parentNode
          break
        case (child.classList.contains("options")):
          parent = child.parentNode.parentNode
          break
        case (child.classList.contains("option")):
          parent = child.parentNode.parentNode.parentNode
          form.f.select.selection(child, parent)
          break
      }
      parent.classList.contains("focused") ? form.f.select.blur(parent) : form.f.select.focus(parent)
    }
  }
}}
window.onload = form.f.init.register
</script>


