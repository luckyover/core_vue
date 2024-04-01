IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M005_ACT1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M005_ACT1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M005_ACT1 '','dasdas','','erew','ewerew','wrewr','rew','rrew','543','5345','rew','re','','rewr','902','M005','172.18.0.1';	
--****************************************************************************************
--*  
--*  処理概要/process overview	:	Insert or update data for delivery
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	QuanLH - ANS902
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M005_ACT1
	@P_delivery_cd					INT				= 0
,	@P_delivery_nm					NVARCHAR(50)	= N''
,	@P_delivery_kn_nm				NVARCHAR(50)	= N''
,	@P_delivery_ab_nm				NVARCHAR(30)	= N''
,	@P_delivery_zip					NVARCHAR(8)		= N''
,	@P_delivery_address1			NVARCHAR(50)	= N''
,	@P_delivery_address2			NVARCHAR(50)	= N''
,	@P_delivery_address3			NVARCHAR(100)	= N''
,	@P_delivery_tel					NVARCHAR(20)	= N''
,	@P_delivery_fax					NVARCHAR(20)	= N''
,	@P_delivery_department_nm		NVARCHAR(30)	= N''
,	@P_delivery_manager_nm			NVARCHAR(30)	= N''
,	@P_delivery_mail_address		NVARCHAR(255)	= N''
,	@P_remarks						NVARCHAR(100)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Insert'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N'delivery_cd=' + CONVERT(NVARCHAR,CONVERT(INT,@P_delivery_cd))
	--

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		IF EXISTS(SELECT 1 FROM M005 WITH(NOLOCK) WHERE delivery_cd = @P_delivery_cd AND del_flg <> 1)
		BEGIN
			SET @w_prs_mode = N'Update'
			UPDATE M005 SET
				delivery_nm					= @P_delivery_nm
			,	delivery_kn_nm				= @P_delivery_kn_nm
			,	delivery_ab_nm				= @P_delivery_ab_nm
			,	delivery_zip				= @P_delivery_zip
			,	delivery_address1			= @P_delivery_address1
			,	delivery_address2			= @P_delivery_address2
			,	delivery_address3			= @P_delivery_address3
			,	delivery_tel				= @P_delivery_tel
			,	delivery_fax				= @P_delivery_fax
			,	delivery_department_nm		= @P_delivery_department_nm
			,	delivery_manager_nm			= @P_delivery_manager_nm
			,	delivery_mail_address		= @P_delivery_mail_address
			,	remarks						= @P_remarks
			,	upd_user_cd					= @P_act_user_cd
			,	upd_prg						= @P_prg
			,	upd_ip						= @P_ip
			,	upd_tm						= @w_time
			,	del_user_cd					= NULL
			,	del_prg						= NULL
			,	del_ip						= NULL
			,	del_tm						= NULL
			,	del_flg						= 0
			WHERE
				delivery_cd					= @P_delivery_cd
		END
		ELSE
		BEGIN
			EXEC SPC_S001_INQ1 N'M005', @P_delivery_cd OUT, @P_act_user_cd, @P_prg, @P_ip
			INSERT INTO M005
			SELECT
				@P_delivery_cd
			,	@P_delivery_nm
			,	@P_delivery_kn_nm
			,	@P_delivery_ab_nm
			,	@P_delivery_zip
			,	@P_delivery_address1
			,	@P_delivery_address2
			,	@P_delivery_address3
			,	@P_delivery_tel
			,	@P_delivery_fax
			,	@P_delivery_department_nm
			,	@P_delivery_manager_nm
			,	@P_delivery_mail_address
			,	@P_remarks
			,	@P_act_user_cd
			,	@P_prg
			,	@P_ip
			,	@w_time
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	0
			--
			SET @w_table_key =	N'delivery_cd=' + CONVERT(NVARCHAR,CONVERT(INT,@P_delivery_cd))
		END
	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	N'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL
	SELECT @P_delivery_cd AS delivery_cd

END
GO
