<?php
/**
 * 地区
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-03
 */
class RegionAction extends AbstractAdminAction{

    public function index(HttpRequest $request){
        $type = intval($request->getParameter('type'));
        $parent = intval($request->getParameter('parent'));
        $target = $request->getParameter('target');
        $cur = intval($request->getParameter('cur'));
        $target = empty($target) ? '' : htmlspecialchars(stripslashes(trim($target)));

        $regionService = AdminServiceFactory::getRegionService();
        $region = array(
            'regions' => $regionService->getRegions($type, $parent),
            'type' => $type,
            'target' => $target,
            'cur' => $cur,
        );
        echo json_encode($region);
        exit();
    }
}
