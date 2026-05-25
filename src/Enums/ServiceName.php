<?php

namespace Asikam\Softone\Enums;

enum ServiceName: string
{
    case BrowserInfo = "getBrowserInfo";
    case BrowserData = "getBrowserData";
    case GetData = "getData";
    case SetData = "setData";
    case ReportInfo = "getReportInfo";
    case ReportData = "getReportData";
    case GetSelectorData = "getSelectorData";
    case SelectorFields  = "selectorFields";

}
