<?php
/**
T4 Overide
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$params = $this->params;
?>

<div id="archive-items" class="com-content-archive__items">
	<?php foreach ($this->items as $i => $item) : ?>
		<?php $info = $item->params->get('info_block_position', 0); ?>
		<div class="row<?php echo $i % 2; ?>" itemscope itemtype="https://schema.org/Article">
			<div class="page-header">
				<h2 itemprop="headline">
					<?php if ($params->get('link_titles')) : ?>
						<a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>" itemprop="url">
							<?php echo $this->escape($item->title); ?>
						</a>
					<?php else : ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
				</h2>

				<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
				<?php echo $item->event->afterDisplayTitle; ?>

				<?php if ($params->get('show_author') && !empty($item->author )) : ?>
					<div class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
					<?php $author = $item->created_by_alias ?: $item->author; ?>
					<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
						<?php if (!empty($item->contact_link) && $params->get('link_author') == true) : ?>
							<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $this->item->contact_link, $author, array('itemprop' => 'url'))); ?>
						<?php else : ?>
							<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
			|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category')); ?>
		<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
			<div class="com-content-archive__info article-info text-muted">
				<dl class="article-info">
				<dt class="article-info-term">
					<?php echo Text::_('COM_CONTENT_ARTICLE_INFO'); ?>
				</dt>

				<?php if ($params->get('show_parent_category') && !empty($item->parent_id)) : ?>
					<dd>
						<div class="parent-category-name">
							<?php $title = $this->escape($item->parent_title); ?>
							<?php if ($params->get('link_parent_category') && !empty($item->parent_id)) : ?>
							<?php if(empty($item->parent_language)) $item->parent_language = null;?>
								<?php $url = '<a href="' . Route::_(
									ContentHelperRoute::getCategoryRoute($item->parent_id, $item->parent_language)
									)
									. '" itemprop="genre">' . $title . '</a>'; ?>
								<?php echo Text::sprintf('COM_CONTENT_PARENT', $url); ?>
							<?php else : ?>
								<?php echo Text::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
							<?php endif; ?>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_category')) : ?>
					<dd>
						<div class="category-name">
							<?php $title = $this->escape($item->category_title); ?>
							<?php if ($params->get('link_category') && $item->catid) : ?>
								<?php 
									if(empty($item->category_language)) $item->category_language = "*";
									$url = '<a href="' . Route::_(
									ContentHelperRoute::getCategoryRoute($item->catid, $item->category_language)
									)
									. '" itemprop="genre">' . $title . '</a>'; ?>
								<?php echo Text::sprintf('COM_CONTENT_CATEGORY', $url); ?>
							<?php else : ?>
								<?php echo Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
							<?php endif; ?>
						</div>
					</dd>
				<?php endif; ?>

				<?php if ($params->get('show_publish_date')) : ?>
					<dd>
						<div class="published">
							<span class="icon-calendar" aria-hidden="true"></span>
							<time datetime="<?php echo HTMLHelper::_('date', $item->publish_up, 'c'); ?>" itemprop="datePublished">
								<?php echo Text::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $item->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>

				<?php if ($info == 0) : ?>
					<?php if ($params->get('show_modify_date')) : ?>
						<dd>
							<div class="modified">
								<span class="icon-calendar" aria-hidden="true"></span>
								<time datetime="<?php echo HTMLHelper::_('date', $item->modified, 'c'); ?>" itemprop="dateModified">
									<?php echo Text::sprintf('COM_CONTENT_LAST_UPDATED', HTMLHelper::_('date', $item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_create_date')) : ?>
						<dd>
							<div class="create">
								<span class="icon-calendar" aria-hidden="true"></span>
								<time datetime="<?php echo HTMLHelper::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
									<?php echo Text::sprintf('COM_CONTENT_CREATED_DATE_ON', HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>

					<?php if ($params->get('show_hits')) : ?>
						<dd>
							<div class="hits">
								<span class="icon-eye-open"></span>
								<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>">
								<?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
							</div>
						</dd>
					<?php endif; ?>
				<?php endif; ?>
				</dl>
			</div>
		<?php endif; ?>

		<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
		<?php echo $item->event->beforeDisplayContent; ?>
		<?php if ($params->get('show_intro')) : ?>
			<div class="intro" itemprop="articleBody"> <?php echo HTMLHelper::_('string.truncateComplex', $item->introtext, $params->get('introtext_limit')); ?> </div>
		<?php endif; ?>

		<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
			<div class="article-info text-muted">
				<dl class="article-info">
				<dt class="article-info-term"><?php echo Text::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>

				<?php if ($info == 1) : ?>
					<?php if ($params->get('show_parent_category') && !empty($item->parent_id)) : ?>
						<dd>
							<div class="parent-category-name">
								<?php $title = $this->escape($item->parent_title); ?>
								<?php if ($params->get('link_parent_category') && $item->parent_id) : ?>
									<?php if(empty($item->parent_language)) $item->parent_language = null;?>
									<?php $url = '<a href="' . Route::_(
										ContentHelperRoute::getCategoryRoute($item->parent_id, $item->parent_language)
										)
										. '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo Text::sprintf('COM_CONTENT_PARENT', $url); ?>
								<?php else : ?>
									<?php echo Text::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_category')) : ?>
						<dd>
							<div class="category-name">
								<?php $title = $this->escape($item->category_title); ?>
								<?php if ($params->get('link_category') && $item->catid) : ?>
									<?php 
									if(empty($item->category_language)) $item->category_language = "*";
									$url = '<a href="' . Route::_(
										ContentHelperRoute::getCategoryRoute($item->catid, $item->category_language)
										)
										. '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo Text::sprintf('COM_CONTENT_CATEGORY', $url); ?>
								<?php else : ?>
									<?php echo Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_publish_date')) : ?>
						<dd>
							<div class="published">
								<span class="icon-calendar" aria-hidden="true"></span>
								<time datetime="<?php echo HTMLHelper::_('date', $item->publish_up, 'c'); ?>" itemprop="datePublished">
									<?php echo Text::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $item->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ($params->get('show_create_date')) : ?>
					<dd>
						<div class="create">
							<span class="icon-calendar" aria-hidden="true"></span>
							<time datetime="<?php echo HTMLHelper::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
								<?php echo Text::sprintf('COM_CONTENT_CREATED_DATE_ON', HTMLHelper::_('date', $item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_modify_date')) : ?>
					<dd>
						<div class="modified">
							<span class="icon-calendar" aria-hidden="true"></span>
							<time datetime="<?php echo HTMLHelper::_('date', $item->modified, 'c'); ?>" itemprop="dateModified">
								<?php echo Text::sprintf('COM_CONTENT_LAST_UPDATED', HTMLHelper::_('date', $item->modified, Text::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_hits')) : ?>
					<dd>
						<div class="hits">
							<span class="icon-eye-open"></span>
							<meta content="UserPageVisits:<?php echo $item->hits; ?>" itemprop="interactionCount">
							<?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
						</div>
					</dd>
				<?php endif; ?>
			</dl>
		</div>
		<?php endif; ?>
		<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
		<?php echo $item->event->afterDisplayContent; ?>
	</div>
	<?php endforeach; ?>
</div>
<div class="com-content-archive__navigation w-100">
	<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="com-content-archive__counter counter float-right pt-3 pr-2">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
	<?php endif; ?>
	<div class="com-content-archive__pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
</div>
